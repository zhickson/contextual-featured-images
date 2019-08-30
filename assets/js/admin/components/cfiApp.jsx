import jQuery from 'jquery';
const { Component } = wp.element;

let frame;

/**
 * A quick and dirty React app to handle
 * the UI in WordPress.
 * 
 * It's easier than jQuery/JS IMO.
 * 
 * @since 1.0.0
 */
export class cfiApp extends Component {
    
    constructor( props ) {

        super( props );

        // Assign initial state
        this.state = {
            isLoaded: false,
            isSelected: false,
            isProcessing: false,
            hasCustomImage: false,
            statusMessage: '',
            error: false,
            termSelectData: props.initialData,
            activeTerm: 'none',
            activeTermData: {},
            workingData: {},
            currentPost: cfi_ajax.current_post
        };

        this.handleTermSelect = this.handleTermSelect.bind(this);
        this.handleSetImageClick = this.handleSetImageClick.bind(this);
        this.handleRemoveImageClick = this.handleRemoveImageClick.bind(this);
        this.handleImageUpload = this.handleImageUpload.bind(this);
        this.handleImageRemove = this.handleImageRemove.bind(this);
        this.loadTermData = this.loadTermData.bind(this);
    }

    // Update state when a term is selected
    handleTermSelect( event ) {
        if ( event.target.value === 'none' ) {
            this.setState({
                activeTerm: event.target.value,
                isSelected: false,
                hasCustomImage: false
            }, () => {
                // once state is ready, update the new state??
                
            });
        } else {
            // here we need to fetch the data for the featured image
            this.setState({
                activeTerm: event.target.value,
                isSelected: true,
            }, () => {
                // once state is ready, update the new state??
                this.loadTermData( this.state.currentPost );
            });
        }
    }

    // Update state when a term is selected
    handleSetImageClick( event ) {
        event.preventDefault();

        const that = this;

        // If the media frame already exists, reopen it.
        if ( frame ) {
            frame.open();
            return;
        }

        // Create a new media frame
        frame = wp.media({
            title: 'Select or Upload Image',
            button: {
                text: 'Use this image'
            },
            multiple: false,  // Set to true to allow multiple files to be selected
            library: {
                type: 'image'
            }
        });

        // Pre-select image
        frame.on( 'open', function(){
            let selection = frame.state().get('selection');
            let selected = that.state.workingData.id; // the ID of the image
            if ( selected ) {
                selection.add( wp.media.attachment( selected ) );
            }
        });

        // When an image is selected in the media frame...
        frame.on( 'select', function() {
        
            // Get media attachment details from the frame state
            const attachment = frame.state().get('selection').first().toJSON();

            that.handleImageUpload( attachment );

        });

        // Finally, open the modal on click
        frame.open();

    }

    handleImageUpload( attachment_data ) {
        const that = this;
        // First we update the state, this displays the image to the user
        this.setState({
            workingData: attachment_data,
            isProcessing: true,
            hasCustomImage: true
        });
        // Next, setup the POST data
        const ajax_data = {
            'action': 'save_custom_image',
            'security': cfi_ajax.nonce,
            'cfi_meta_key': '_cfi_catch_' + this.state.activeTerm,
            'cfi_post_id': cfi_ajax.current_post,
            'cfi_attachment_id': attachment_data.id
        };
        // Send the meta to database through AJAX
        // TODO: replace with wp.ajax.send or similar
        jQuery.ajax({
            method: 'POST',
            url: cfi_ajax.url,
            data: ajax_data
        })
        // Once it's done, update state again
        .success( function( response ) {
            that.setState({
                isProcessing: false,
                statusMessage: response.data.message ? response.data.message  : '',
            });
        })
        .error( function( response ) {
            that.setState({
                error: true,
                isProcessing: false,
                hasCustomImage: false,
                statusMessage: response.data.message ? response.data.message  : '',
            });
        });
    }

    // Update state when a term is selected
    handleRemoveImageClick( event ) {
        event.preventDefault();

        const that = this;

        that.handleImageRemove( this.state.workingData );

    }

    handleImageRemove( old_data ) {
        const that = this;
        // First we update the state, this displays the image to the user
        this.setState({
            hasCustomImage: false,
            isProcessing: true
        });
        // Next, setup the POST data
        const ajax_data = {
            'action': 'remove_custom_image',
            'security': cfi_ajax.nonce,
            'cfi_meta_key': '_cfi_catch_' + this.state.activeTerm,
            'cfi_post_id': cfi_ajax.current_post,
            'cfi_attachment_id': old_data.id
        };
        // Send the meta to database through AJAX
        jQuery.ajax( {
            method: 'POST',
            url: cfi_ajax.url,
            data: ajax_data
        } )
        // Once it's done, update state again
        .success( function( response ) {
            that.setState({
                isProcessing: false,
                hasCustomImage: false,
                statusMessage: response.data.message ? response.data.message  : '',
                workingData: {}
            });
            // Maybe trigger a "Saved" notice?
        })
        .error( function( response ) {
            that.setState({
                error: true,
                isProcessing: false,
                hasCustomImage: true,
                statusMessage: response.data.message ? response.data.message  : '',
            });
        });
    }

    loadTermData( post_id ) {
        const that = this;
        // First we update the state, this displays the image to the user
        this.setState({
            hasCustomImage: false,
            isProcessing: true
        });
        // Next, setup the POST data
        const ajax_data = {
            'action': 'get_custom_image_ajax',
            'security': cfi_ajax.nonce,
            'cfi_meta_key': '_cfi_catch_' + this.state.activeTerm,
            'cfi_post_id': post_id
        };
        // Fetch the meta to database through AJAX
        jQuery.ajax( {
            method: 'POST',
            url: cfi_ajax.url,
            data: ajax_data
        } )
        // Once it's done, update state again
        .success( function( response ) {
            if ( response.data.attachment ) {
                that.setState({
                    isProcessing: false,
                    hasCustomImage: true,
                    statusMessage: response.data.message ? response.data.message  : '',
                    workingData: response.data.attachment
                });
            } else {
                that.setState({
                    isProcessing: false,
                    hasCustomImage: false,
                    statusMessage: response.data.message ? response.data.message  : '',
                    workingData: response.data.attachment
                });
            }
        })
        .error( function( response ) {
            that.setState({
                error: true,
                isProcessing: false,
                hasCustomImage: false,
                statusMessage: response.data.message ? response.data.message  : '',
            });
        });
    }

    render() {
        const { 
            error, 
            isLoaded, 
            isProcessing,
            isSelected, 
            activeTerm, 
            activeTermData, 
            termSelectData, 
            workingData, 
            hasCustomImage,
            statusMessage 
        } = this.state;

        return (
            <div id='cfiWrap'>
                <div className='cfi-container'>

                    <div id="cfiConditions">
                        <p><strong>Select a term</strong></p>

                        <select value={activeTerm} className="cfi-select" onChange={this.handleTermSelect}>
                            <option value="none">-- Select Term --</option>
                            {termSelectData.map(term => (
                                <option key={term.id} value={term.id}>{term.name}</option>
                            ))}
                        </select>

                        <p className='cfi-notif cfi-info'><small>If you don't see any terms listed, make sure to first assign this post to a term, and then update the post and/or refresh the page to see the term in the dropdown.</small></p>
                    </div>
                    <div id='cfiMedia'>
                        { isSelected ? (
                            <div>
                                <p><strong>Set or update featured image</strong></p>
                                <div id="cfi_custom_img_container" className={ hasCustomImage ? 'show' : 'hidden' }>
                                    <button type="button" aria-lable="Edit or update the image" className="editor-post-featured-image__preview" onClick={this.handleSetImageClick}>
                                        <div className="cfi-img-wrapper">
                                            <img src={ workingData ? workingData.url : '' } alt="" />
                                        </div>
                                    </button>
                                </div>
                                <div id="cfi_loader" className={ isProcessing ? 'show' : 'hidden' }><span className="spinner"></span></div>
                                <p class="hide-if-no-js">
                                    <button className="upload-custom-img button components-button is-button is-default" id="cfi_upload_img_btn" onClick={this.handleSetImageClick}>{ hasCustomImage ? 'Replace image' : 'Set custom image' }</button>
                                    <button className="delete-custom-img components-button is-link is-destructive button-link-delete" id="cfi_remove_img_btn" onClick={this.handleRemoveImageClick}>Remove this image</button>
                                </p>
                                <input id="cfi_meta_key" name="cfi_meta_key" type="hidden" value={ '_cfi_catch_' + activeTerm } />
                                <input id="cfi_cat_id" name="cfi_cat_id" type="hidden" value={ activeTerm } />
                                <input id="cfi_attachment_id" name="cfi_attachment_id" type="hidden" value={ workingData ? workingData.id : '' } />
                                <input id="cfi_post_id" name="cfi_post_id" type="hidden" value="" />
                            </div>
                        ) : (
                            <p><em>Select a term first...</em></p>
                        ) }
                    </div>

                </div>
            </div>
        );
    }
}