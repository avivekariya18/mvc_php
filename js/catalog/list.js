let filter = {
  data: {},

  // Retrieve selected values for checkboxes
  getSelectedValues: function (name) {
    return $('input[name="' + name + '[]"]:checked')
      .map(function () {
        return $(this).val();
      })
      .get();
  },

  // Retrieve selected value for radio buttons
  getSelectedRadio: function (name) {
    return $('input[name="' + name + '"]:checked').val() || null;
  },

  // Retrieve text from search input safely
  getSelectedSearch: function (name) {
    let searchInput = $('input[name="' + name + '"]');
    return (searchInput.val() || "").trim(); // Ensure a string is always returned
  },

  // Update the filter data object
  updateData: function () {
    let selectedCategories = this.getSelectedValues("category_id");
    let selectedSize = this.getSelectedValues("size");
    let selectedMaterial = this.getSelectedValues("material");
    let selectedColor = this.getSelectedValues("color");
    let selectedPrice = this.getSelectedRadio("price");
    let selectedSearch = this.getSelectedSearch("search");
    
    this.data = {}; // Clear previous data

    if (selectedCategories.length > 0) this.data.category_id = selectedCategories.join(",");
    if (selectedSize.length > 0) this.data.size = selectedSize.join(",");
    if (selectedMaterial.length > 0) this.data.material = selectedMaterial.join(",");
    if (selectedColor.length > 0) this.data.color = selectedColor.join(",");
    if (selectedPrice) this.data.price = selectedPrice;

    // Check for exact match with .card-title
    if (selectedSearch) {
      $(".card-title").each(function () { // Ensure correct selector
        if ($(this).text().trim() === selectedSearch) {
          console.log("Exact match found!", selectedSearch);
          filter.data.search = selectedSearch;
        }
      });
    }

    console.log("Updated data:", this.data);
    this.updateURL(); // Update URL with new filters
  },

  // Update the URL with the current filters without refreshing the page
  updateURL: function () {
    const queryParams = new URLSearchParams(this.data).toString();
    const newURL = window.location.origin + window.location.pathname + "?" + queryParams;
    window.history.pushState({ path: newURL }, "", newURL);
  },

  // Fetch filtered products using AJAX
  fetchFilteredProducts: function () {
    $.ajax({
      url: "http://localhost/mvc_new/catalog/product/list/",
      method: "GET",
      data: this.data,
      success: function (response) {
        let extractedContent = $(response).find("#product-list").html();
        $("#product-list").html(extractedContent);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching data:", error);
      },
    });
  },
};

// Event listener for checkboxes, radio buttons, and search input
$(document).on(
  "change",
  'input[type="checkbox"], input[type="radio"], input[name="search"]',
  function () {
    filter.updateData();
    filter.fetchFilteredProducts();
  }
);

// Live search by product name
$(document).on("input", 'input[name="search"]', function () {
  filter.updateData();
  filter.fetchFilteredProducts();
});