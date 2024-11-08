console.log("script.js loaded");
function initTinyMCE() {
    tinymce.init({
        selector: '#comment-textarea',  // Ensure selector matches the ID
        width: 1000,
        height: 300,
        plugins: [
            'advlist', 'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
            'searchreplace', 'wordcount', 'visualblocks', 'code', 'fullscreen', 'insertdatetime', 'media',
            'table', 'emoticons', 'template', 'codesample'
        ],
        toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright alignjustify |' +
                 'bullist numlist outdent indent | link image | print preview media fullscreen | ' +
                 'forecolor backcolor emoticons',
        menu: {
            favs: {title: 'menu', items: 'code visualaid | searchreplace | emoticons'}
        },
        menubar: 'favs file edit view insert format tools table',
        content_style: 'body { font-family:Helvetica, Arial, sans-serif; font-size:16px }',
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();  // Ensure TinyMCE updates the underlying textarea
                Livewire.emit('inputChanged', editor.getContent());  // Emit updated content to Livewire
            });
        }
    });
}

// Initialize TinyMCE on page load
document.addEventListener("livewire:load", initTinyMCE);

// Reinitialize TinyMCE after Livewire updates
Livewire.hook('message.processed', (message, component) => {
    tinymce.remove();  // Remove previous instances to avoid duplicates
    initTinyMCE();
});
