console.log( 'Submit-Form Plugin loaded' );

// const homeUrl = window.location.origin;
// const fileURL = homeUrl + '/wp-json/wp/v2/documents';
//
// const fileUploadBtn = document.querySelector('#slf-fileupload');
//
// const loadContentBtn = document.querySelector('#loadcontent');
// const divContent = document.querySelector('.hello');
//
//
// // load content on submission page
// loadContentBtn.addEventListener( 'click', () => {
//   const xhttp = new XMLHttpRequest();
//
//   xhttp.open('GET', fileURL, true);
//   xhttp.onload = () => {
//     let data = JSON.parse(xhttp.responseText);
//     createHTML(data);
//     loadContentBtn.remove();
//   }
//   xhttp.send();
// } );
//
// // Create html
// function createHTML( postsData ){
//   let htmlString = '';
//   for (var i = 0; i < postsData.length; i++) {
//     htmlString += '<h4>' + postsData[i].title.rendered + '</h4>';
//     htmlString +=  postsData[i].content.rendered;
//   }
//
//   divContent.innerHTML = htmlString;
// }





// Quick Submit Form ajax
// const submitFormBtn = document.querySelector('#submit_userform');
//
// // check if button is available
//   submitFormBtn.addEventListener( 'click', () => {
//     var ourFormData = {
//       "title": document.querySelector('.submit__left [name="slf-name"]').value,
//       "content": document.querySelector('.submit__left [name="slf-abstract"]').value,
//       "status": 'publish'
//     }
//
//     var createSubmission = new XMLHttpRequest();
//     createSubmission.open( "POST", fileURL );
//     createSubmission.setRequestHeader("X-WP-Nonce", veriData.nonce);
//     createSubmission.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
//     createSubmission.send(JSON.stringify(ourFormData));
//
//   } );
