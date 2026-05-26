<!-- Helpers -->
<script src="assets/template/assets/vendor/js/helpers.js"></script>

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="assets/template/assets/js/config.js"></script>

<!-- TinyMCE -->
<script src="
https://cdn.jsdelivr.net/npm/tinymce@7.4.0/tinymce.min.js
"></script>

<script>
  tinymce.init({
    selector: 'textarea#default-editor',
    plugins: [
      "advlist", "anchor", "autolink", "charmap", "code", "fullscreen",
      "help", "image", "insertdatetime", "link", "lists", "media",
      "preview", "searchreplace", "table", "visualblocks",
    ],
    toolbar: "undo redo | styles | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
  });
</script>