(function (Drupal, once) {
  Drupal.behaviors.autoAltBehavior = {
    attach: function (context, settings) {
      once('autoAltBehavior', '#edit-field-media-image-0-alt', context).forEach(function (element) {
        // Move the wand to where it should be.
        let wand = context.getElementById("autoalt");
        let mediaMeta = context.querySelector('.form-managed-file__meta-items');
        mediaMeta.append(wand);
        wand.addEventListener('click', generateAltText);
      });

      async function generateAltText() {
        let imageUrl = document.querySelector('.image-preview__img-wrapper img').src;
        const url = "/ai/alt-text-generator?";
        try {
          const response = await fetch(url + new URLSearchParams({
            image: imageUrl,
          }).toString());
          if (!response.ok) {
            throw new Error(`Response status: ${response.status}`);
          }

          const json = await response.json();
          let altInput = document.getElementById('edit-field-media-image-0-alt');
          altInput.value = json;
        } catch (error) {
          console.error(error.message);
        }
      }
    }
  };
})(Drupal, once);
