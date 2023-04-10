ClassicEditor
    .create(document.querySelector('#texto_post'), {
        // The language code is defined in the https://en.wikipedia.org/wiki/ISO_639-1 standard.
        language: 'pt-br'
    })
    .then(editor => {
        console.log(editor);
    })
    .catch(error => {
        console.error(error);
    });