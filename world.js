document.addEventListener("DOMContentLoaded", () => {
  const lookupCountryBtn = document.getElementById("lookup");
  const lookupCitiesBtn = document.getElementById("lookup-cities");
  const resultDiv = document.getElementById("result");
  const countryInput = document.getElementById("country");

  function fetchData(lookupType) {
    const country = countryInput.value.trim();
    const params = new URLSearchParams();
    params.set("country", country);
    params.set("lookup", lookupType);



    fetch(`world.php?${params.toString()}`)
      .then(response => {
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        return response.text();
      })
      .then(data => {
        resultDiv.innerHTML = data;
      })
      .catch(error => {
        resultDiv.innerHTML = `<p>Error: ${error.message}</p>`;
      });
  }
  

  lookupCountryBtn.addEventListener("click", () => fetchData("countries"));
  lookupCitiesBtn.addEventListener("click", () => fetchData("cities"));
});
