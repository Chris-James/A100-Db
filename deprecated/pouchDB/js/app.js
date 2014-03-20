 window.onload = function() {

  'use strict';

  var db = new PouchDB('cities');
  var remoteCouch = false;

  var saveButton = document.getElementById('saveButton');
  var displayButton = document.getElementById('displayButton');
  var destroyButton = document.getElementById('destroyButton');

  //Functions
  var addToDb = function() {
    var name = document.getElementById('cityName').value;
    db.post({name: name});
    console.log("City Name was saved.");
  }

  var displayCount = function() {
    db.allDocs({include_docs:true,descending:true},function(err, response) {
      if (!err) {
        response.rows.forEach(function(element){
          console.log(element.doc.name);
        });
      }
    });
  }

var removeRecord = function() {
  db.get('NEWNENWNWCITY').then(function(doc){
    return db.remove(doc);
  });
}

  //Action Listeners
  saveButton.addEventListener('click', addToDb, false);
  displayButton.addEventListener('click', displayCount, false);
  destroyButton.addEventListener('click', removeRecord, false);


  if (remoteCouch) {
    sync();
  }

}