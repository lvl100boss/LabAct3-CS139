let deleteButtons = document.querySelectorAll('.delete-button');

// Iterate over each button
deleteButtons.forEach(button => {
    // Add a 'click' event listener to each button
    button.addEventListener('click', function(e) {
        // Prevent the default action of the click event (e.g., navigation or form submission)
        e.preventDefault();
        
        // Get the product name and id from the button's data attributes
        let Book = this.dataset.name;
        let BookID = this.dataset.id;
        
        // Ask the user for confirmation to delete the product
        let response = confirm("Do you want to delete the product " + Book + "?");

        // If the user confirms deletion
        if (response) {
            // Send a GET request to delete the product using the fetch API
            fetch('deletebook.php?id=' + BookID, {
                method: 'GET'
            })
            .then(response => response.text())  // Parse the response as plain text
            .then(data => {
                // If the server responds with 'success'
                if(data === 'success') {
                    // Redirect the user to 'product.php'
                    window.location.href = 'viewbooks.php';
                }
            });
        }
    });
});