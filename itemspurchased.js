var username = "<?php echo $username ?>";
getItems();

function getItems(){
    //var dataString = "token=" + encodeURIComponent(token);
    var dataString = "username=" + encodeURIComponent(username);
    var eventXmlHttp = new XMLHttpRequest(); // Initialize our XMLHttpRequest instance
    eventXmlHttp.open("POST", "itemspurchased.php", true); 
    eventXmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded"); 
    eventXmlHttp.addEventListener("load", function(event){
        //ITEMS.push({id:49, name:"bobby", desc:"for sittingaf"});
        var pITEMS = JSON.parse(event.target.responseText);
        if(pITEMS[0].success){
          // alert(pITEMS[1].item_name);
          // return pITEMS[1].item_name;
          var itemArr = [];
          for(i = 1; i < pITEMS.length; i++){
            itemArr.push({id:pITEMS[i].buyer_id, name:pITEMS[i].item_name, desc:pITEMS[i].item_desc});
          }
          stupid(itemArr);
        }
        else{
            alert("Failed to retreive events");
        }
    }, false);
    eventXmlHttp.send(dataString); // Send the data
}

function stupid(itemArr){
  var ITEMS = itemArr;
  let Item = React.createClass({
    displayName: 'Item',
    render: function render() {
        return React.createElement(
        'li',
        null,
        React.createElement(
          'span',
           { className: 'itemname' },
           "Item Name: "+this.props.name
        ),
        React.createElement(
          'span',
          { className: 'desc' },
          "Item Description: "+this.props.desc
        ),
        React.createElement(
          'span',
          { className: 'buyer id' },
          "Buyer ID: "+this.props.id
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
          return React.createElement(Item, {
            name: el.name,
            desc: el.desc,
            id: el.id
            //,
            //atc: "Add to Cart"
          });
        })
      )
    );
  }
});

ReactDOM.render(React.createElement(ItemList, null), document.getElementById('app'));
}