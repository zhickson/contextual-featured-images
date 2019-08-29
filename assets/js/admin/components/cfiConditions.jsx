const { Component } = wp.element;

class cfiConditions extends Component {
    constructor(props) {
        super(props);

        this.handleCategorySelect = this.handleCategorySelect.bind(this);

    }
    handleCategorySelect(event) {
        this.props.onCategorySelect(event.target.value);
    }

    render() {

        const { activeCategory, data } = this.props;

        return (
            <div>
                <p><strong>Select a category</strong></p>

                <select value={activeCategory} className="form-control" onChange={this.handleCategorySelect}>
                    <option value="none">-- Select Category --</option>
                    {data.map(category => (
                        <option key={category.id} value={category.id}>{category.name}</option>
                    ))}
                </select>

                <p className='cfi-notif cfi-info'><small>If you don't see any categories listed, make sure to first assign this post to a category, and then update the post and/or refresh the page to see the category in the dropdown.</small></p>
            </div>
        );
    }
}

export default cfiConditions;