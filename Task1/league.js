function league() {
    fetch('League.json')
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        // Once JSON data is loaded, you can work with it here
        console.log(data);
      })
      .catch(error => {
        console.error('There was a problem fetching the data:', error);
      });
  }
  