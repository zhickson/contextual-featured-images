const { Component } = wp.element;

class cfiMedia extends Component {
    constructor(props) {
        super(props);

        this.handleImageUpdate = this.handleImageUpdate.bind(this);

    }
    handleImageUpdate(event) {
        this.props.onImageUpdate(event.target.value);
    }

    render() {

        const { data } = this.props;

        return (
            <div>
                <p><strong>Set or Update Featured Image</strong></p>
                <p class="hide-if-no-js">
                    <a className="upload-custom-img" href="#" id="cfi_upload_img_btn">Set custom image</a>
                    <a className="delete-custom-img" href="#">Remove this image</a>
                </p>
                <input class="cfi-custom-img-id" name="cfi-custom-img-id" type="hidden" value="" />
            </div>
        ); 
    }
}

export default cfiMedia;