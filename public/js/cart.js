document.querySelectorAll('input[name="stock"]').forEach((radio) => {
    radio.addEventListener("change", function () {
        if (this.checked) {
            const selectedId = this.getAttribute("data-id");
            const selectedAttributeId = this.getAttribute("data-attribute-id");
            document.getElementById("selectedId").value = selectedId;
            document.getElementById("selectedAttributeId").value =
                selectedAttributeId;
        }
    });
});
