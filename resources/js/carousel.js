const carouselItems = document.querySelectorAll(".carousel_items");

carouselItems.forEach(item => {
    item.addEventListener("click", function () {
        const dataId = item.dataset.id;

        const activeItem = document.querySelector(".carousel_items.active");
        if (activeItem) {
            activeItem.classList.remove("active");
        }

        item.classList.add("active");

        const clickedImageUrl = item.querySelector("img").src;

        const carouselImageShow = document.querySelector(".image_show img");
        carouselImageShow.src = clickedImageUrl;

        const carouselItemsWithSameDataId = document.querySelectorAll(
            `.carousel_items_[data-id="${dataId}"]`
        );
        carouselItemsWithSameDataId.forEach(item => {
            item.classList.add("active");
        });

        const activeItemModals = document.querySelectorAll(".carousel_items_.active");
        activeItemModals.forEach(item => {
            if (item.dataset.id !== dataId) {
                item.classList.remove("active");
            }
        });
    });
});

