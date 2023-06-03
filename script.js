window.addEventListener('DOMContentLoaded', function() {
    var images = document.querySelectorAll('.image-wrapper img');
  
    images.forEach(function(image) {
      image.addEventListener('load', function() {
        var width = this.naturalWidth;
        var height = this.naturalHeight;
        var ratio = width / height;
  
        if (ratio > 1) {
          // Horizontal, menggunakan rasio 4:3
          this.parentElement.style.paddingBottom = '75%';
        } else {
          // Vertikal, menggunakan rasio 3:4
          this.parentElement.style.paddingBottom = '133.33%';
        }
      });
    });
  });
  