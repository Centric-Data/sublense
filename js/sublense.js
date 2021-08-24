console.log( 'Submit-Form Plugin loaded' );

const attachBtn = document.querySelector('#attach__button');
const fileUploadBtn = document.querySelector('#slf-fileupload');

attachBtn.addEventListener( 'click', (e) => {
  e.preventDefault;
  console.log('Locate file');

  setTimeout( () => {
    fileUploadBtn.click();
  }, 200 );


} );
