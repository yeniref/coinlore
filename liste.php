<main> 
  <table>
    <thead>
      <tr>
        <th>Koin Adı</th>
        <th>Sembol</th>
        <th>Fiyat</th>
        <th>Piyasa Değeri</th>
        <th>Toplam Koin</th>
        <th>Maksimum Koin</th>
        <th>Değişim</th>

      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
  
  <div class='buttonContainer'>
    <button class="previousButton">&#8592; Önceki</button>
    <button class="nextButton">Sonraki &#8594;</button>
  </div>
</main>

<style>

main {
  margin-left: auto;
  margin-right: auto;
  margin-top: 10px;
  box-shadow: 3px 3px 10px 1px #9F9F9F;
}

table {
  width: 100%; 
}

table tr {
  text-align: left;
}

thead tr {
  background-color: #ffffff;
  font-weight: bold;
}

tbody tr:nth-child(odd) {
  background-color: #F0EEF0;
}

tbody tr:nth-child(even) {
  background-color: #ffffff;
}

th, td {
  padding-left: 10px;
  height: 40px;
  vertical-align: middle;
}


.invisible {
  display: None;
}

.visible {
  display: inline;
}

.nextButton {
  float: right;
  margin-right: 8px;
}

.buttonContainer {
  background-color: #F0EEF0;
  width: 100%;
  height: 40px;
  margin-bottom: 50px;
  margin-left: auto;
  margin-right: auto;
}

button {
  background-color: #F0EEF0;
  border: 0px;
  margin: 10px 5px 10px 10px;
  border-radius: 0px;
  font-weight: bold;
  font-size: 0.9em;
  height: 20px
}

button:hover {
  border: 0.7px solid #A4A4A4;
}

@media all and (max-width: 500px) {
  main {
    margin-top: 40px;
    margin-left: 10px;
    margin-right: 10px;
  }
  
  table, thead, tbody, th, td {
    display: flex;
    flex-flow: column nowrap;
  }
  
  td {
    min-height: 40px;
    vertical-align: middle;
    flex-basis: 1;
    margin: 5px 5px 0px 5px;
    padding: 10px;
  }
  
  tr {
    display: grid;
    grid-template-columns: repeat(auto-fill,minmax(170px, 1fr));
    min-height: 160px;
  }
  
  td:before {
		padding-right: 10px;
    font-weight: bold;
  }
  
  td:nth-of-type(1):before {
    content: "Koin Adı";
  }
  td:nth-of-type(2):before {
    content: "Sembol";
  }
  td:nth-of-type(3):before {
    content: "Fiyat";
  }
  td:nth-of-type(4):before {
    content: "Piyasa Değeri";
  }
  td:nth-of-type(5):before {
    content: "Toplam Koin";
  }
  td:nth-of-type(6):before {
    content: "Maksimum Koin";
  }
  td:nth-of-type(7):before {
    content: "Değişim";
  }
  thead tr { 
		position: absolute;
		top: -10000px;
		left: -10000px;
	}
}
</style>

<script>

let startValue = 0;
const currencySymbol = '$';
const yuzde = '%'
const insertRowForEachCoin = (coin) => {
  const { name, symbol, market_cap_usd, price_usd, tsupply,msupply,percent_change_24h} = coin;
  
  const tableBody = document.querySelector('table tbody');
  
  const newRow = tableBody.insertRow();
  
  const coinName = newRow.insertCell(0);
  coinName.appendChild(document.createTextNode(name));
  
  const code = newRow.insertCell(1);
  code.appendChild(document.createTextNode(symbol));

  const price = newRow.insertCell(2);
  price.appendChild(document.createTextNode(`${currencySymbol} ${price_usd}`));
  
  const market = newRow.insertCell(3);
  market.appendChild(document.createTextNode(`${currencySymbol} ${market_cap_usd}`));

  const totalSupply = newRow.insertCell(4);
  totalSupply.appendChild(document.createTextNode(`${tsupply} ${symbol}`));

  const maxkoin = newRow.insertCell(5);
  maxkoin.appendChild(document.createTextNode(`${msupply} ${symbol}`));

  const degisim = newRow.insertCell(6);
  degisim.appendChild(document.createTextNode(`${percent_change_24h} ${yuzde}`));

};

const updateTable = (coinData) => {
  // clear the table first
  const tableBody = document.querySelector('table tbody');
  const newTableBody = document.createElement('tbody');
  tableBody.parentNode.replaceChild(newTableBody, tableBody);
  
  //insert the data into the table
  coinData.forEach((coin) => insertRowForEachCoin(coin));
};

const getData = (startValue) => {
  fetch(`https://api.coinlore.com/api/tickers/?start=${startValue}&limit=${99}`)
   .then(validateResponse)
   .then((response) => response.json())
   .then((data) => {const coinData = data.data; console.log(coinData); updateTable(coinData);})
   .catch((error) => error );
};


document.addEventListener("DOMContentLoaded", (event) => { 
  getData(0);
  previousButton.classList.toggle('invisible');
  console.log('document is ready')
});

const previousButton = document.querySelector('.previousButton');
previousButton.addEventListener('click', (event) => {
  if (startValue >= 10) {
    startValue -= 10;
    getData(startValue);
  }
  if (startValue === 0) {
    // Add a class to hide the button
    previousButton.classList.remove('visible');
    previousButton.classList.add('invisible');
  }
});

const nextButton = document.querySelector('.nextButton');
nextButton.addEventListener('click', (event) => {
  startValue += 10;
  getData(startValue);
  previousButton.classList.add('visible');
});

const validateResponse = (response) => {
  if (!response.ok) {
    throw Error(response.statusText);
  } else {
    return response;
  }
};

</script>
