document.addEventListener("DOMContentLoaded", () => {
  const lookupBtn = document.getElementById("lookup");
  const resultDiv = document.getElementById("result");

  lookupBtn.addEventListener("click", () => {
    const country = document.getElementById("country").value.trim();

    fetch(`world.php?country=${encodeURIComponent(country)}`)
      .then(response => response.text())
      .then(data => {
        resultDiv.innerHTML = data;
      })
      .catch(error => {
        resultDiv.innerHTML = `<p>Error: ${error}</p>`;
      });
  });
});
