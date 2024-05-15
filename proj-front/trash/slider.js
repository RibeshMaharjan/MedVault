
let currentIndex = 0;

function initializeSlider(productid) {
    const sliderContainer = document.getElementById('slider' + productid);
    const images = sliderContainer.querySelectorAll('.slide');

    function showImage(index) {

        if (index >= images.length) {
            currentIndex = 0;
        } else if (index < 0) {
            currentIndex = images.length - 1;
        }

        images.forEach((image, i) => {
            image.style.display = i === currentIndex ? 'block' : 'none';
        });

        
        }

        function nextSlide() {
        currentIndex++;
        showImage(currentIndex);
        }

        function prevSlide() {
        currentIndex--;
        showImage(currentIndex);
        }

        showImage(currentIndex);

        return {
        nextSlide,
        prevSlide,
    };
}

    function prevSlide(productid) {
        initializeSlider(productid).prevSlide();
    }

    function nextSlide(productid) {
        initializeSlider(productid).nextSlide();
}