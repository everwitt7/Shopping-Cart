let ITEMS = [
    {
        id: 1,
        name: 'Basketball',
        desc: 'Recreational Sports Equipment'
    },
    {
        id: 2,
        name: 'Baseball',
        desc: 'Recreational Sports Equipment'   
    },
    {
        id: 3,
        name: 'Macbook',
        desc: 'Person Computer'
    },
    {
        id: 4,
        name: 'Notebook',
        desc: 'School Supplies'
    },
    {
        id: 5,
        name: 'Pencil',
        desc: 'School Supplies'
    }
]; 

let Item = React.createClass({
    displayName: 'Item',
    render: function render() {
        return React.createElement(
        'li',
        null,
        React.createElement(
          'span',
           null,
           this.props.name
        ),
        React.createElement(
          'span',
          { className: 'desc' },
          this.props.desc
        )
        );
    }
});

var ItemList = React.createClass({
  displayName: 'ItemList',
  getInitialState: function getInitialState() {
    return {
      displayedItems: ITEMS
    };
  },
  searchHandler: function searchHandler(event) {
    var searcjQery = event.target.value.toLowerCase(),
        displayedItems = ITEMS.filter(function (el) {
      var searchValue = el.name.toLowerCase();
      return searchValue.indexOf(searcjQery) !== -1;
    });
    this.setState({
      displayedItems: displayedItems
    });
  },
  render: function render() {
    var items = this.state.displayedItems;
    return React.createElement(
      'div',
      { className: 'holder' },
      React.createElement('input', { type: 'text', classNAme: 'search', onChange: this.searchHandler }),
      React.createElement(
        'ul',
        null,
        items.map(function (el) {
          return React.createElement(Item, { key: el.id,
            name: el.name,
            desc: el.desc
          });
        })
      )
    );
  }
});

ReactDOM.render(React.createElement(ItemList, null), document.getElementById('app'));