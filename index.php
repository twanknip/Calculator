<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koffiezetapparaat Verkoop</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    <script>
        const models = {
            "Philips": ["EP 2300 series", "EP 3300 series", "EP 4300 series", "EP 4400 series", "EP 5300 series", "EP 5400 series", "EP 5500 series"],
            "Jura": ["A series", "D series", "Ena series", "Ena 8", "E series", "F series", "GIGA series", "GIGA X7C", "GIGA X series", "GIGA 10 series", "X series", "XF series", "S series", "XS series", "J 5 tm 7 series", "J8", "J9 & J10 series", "WE series", "Z5", "Z6", "Z7"],
            "DeLonghi": ["Dinamica series", "Primadonna series", "Primadonna Elite series", "Primadonna Exclusive series", "Eletta series", "Maestosa series", "Cappuccino series"],
            "Siemens": ["EQ6 S100", "EQ6 PLUS S100", "EQ6 S300", "EQ6 PLUS S300", "EQ6 S400", "EQ6 PLUS S400", "EQ6 S500", "EQ6 PLUS S500", "EQ6 S700", "EQ6 PLUS S700", "EQ6 PLUS S800", "EQ6 PLUS EXTRA KLASSE", "EQ9 series", "Inbouw machines"],
            "Sage": ["Barista express series", "Barista Pro series", "Barista Touch series", "Oracle series"],
            "Solis": ["Grind & Infuse series", "Espresso bar series"],
            "Gaggia": ["Titanium", "Platinum", "Brera"],
            "Nivona": ["CafeRomatica series"],
            "Melitta": ["Barista series", "Caffeo Cl series", "Avanza series", "Caffeo Passione"],
            "Saeco": ["Xelsis series", "Pico Barista series", "Lirika"],
            "Atag": ["Inbouw machines"],
            "Miele": ["Inbouw machines"],
            "Bauknecht": ["Inbouw machines"]
        };

        const basePrices = {
            "Philips": {"EP 2300 series": 70, "EP 3300 series": 80, "EP 4300 series": 125, "EP 4400 series": 125, "EP 5300 series": 80, "EP 5400 series": 150, "EP 5500 series": 125},
            "Jura": {"A series": 80, "D series": 150, "Ena series": 100, "Ena 8": 125, "E series": 150, "F series": 130, "GIGA series": 425, "GIGA X7C": 425, "GIGA X series": 700, "GIGA 10 series": 700, "X series": 700, "XF series": 150, "S series": 200, "XS series": 200, "J 5 tm 7 series": 125, "J8": 450, "J9 & J10 series": 175, "WE series": 200, "Z5": 200, "Z6": 350, "Z7": 350},
            "DeLonghi": {"Dinamica series": 75, "Primadonna series": 100, "Primadonna Elite series": 175, "Primadonna Exclusive series": 125, "Eletta series": 100, "Maestosa series": 300, "Cappuccino series": 100},
            "Siemens": {"EQ6 S100": 75, "EQ6 PLUS S100": 75, "EQ6 S300": 75, "EQ6 PLUS S300": 75, "EQ6 S400": 110, "EQ6 PLUS S400": 110, "EQ6 S500": 110, "EQ6 PLUS S500": 125, "EQ6 S700": 150, "EQ6 PLUS S700": 170, "EQ6 PLUS S800": 200, "EQ6 PLUS EXTRA KLASSE": 200, "EQ9 series": 300, "Inbouw machines": 120},
            "Sage": {"Barista express series": 100, "Barista Pro series": 120, "Barista Touch series": 150, "Oracle series": 200},
            "Solis": {"Grind & Infuse series": 80, "Espresso bar series": 100},
            "Gaggia": {"Titanium": 60, "Platinum": 80, "Brera": 50},
            "Nivona": {"CafeRomatica series": 130},
            "Melitta": {"Barista series": 100, "Caffeo Cl series": 90, "Avanza series": 90, "Caffeo Passione": 80},
            "Saeco": {"Xelsis series": 150, "Pico Barista series": 120, "Lirika": 90},
            "Atag": {"Inbouw machines": 130},
            "Miele": {"Inbouw machines": 130},
            "Bauknecht": {"Inbouw machines": 130}
        };

        function updateModels() {
            let brandSelect = document.getElementById('brand');
            let modelSelect = document.getElementById('model');
            let selectedBrand = brandSelect.value;

            modelSelect.innerHTML = '';

            if (models[selectedBrand]) {
                models[selectedBrand].forEach(function (model) {
                    let option = document.createElement('option');
                    option.value = model;
                    option.text = model;
                    modelSelect.add(option);
                });
            }
            calculatePrice(); 
        }

        function calculatePrice() {
            let brand = document.getElementById('brand').value;
            let model = document.getElementById('model').value;
            let condition = parseFloat(document.querySelector('input[name="condition"]:checked')?.value) || 100;
            let electronics = parseFloat(document.querySelector('input[name="electronics"]:checked')?.value) || 0;
            let accessories = parseFloat(document.querySelector('input[name="accessories"]:checked')?.value) || 0;
            let cleaning = parseFloat(document.querySelector('input[name="cleaning"]:checked')?.value) || 0;

            if (brand && model && basePrices[brand] && basePrices[brand][model]) {
                let basePrice = basePrices[brand][model];

                let finalPrice = basePrice * (condition / 100);
                finalPrice += finalPrice * (electronics / 100);
                finalPrice += finalPrice * (accessories / 100);
                finalPrice += finalPrice * (cleaning / 100);

                document.getElementById('priceOutput').innerText = `De geschatte waarde van uw ${brand} ${model} is: €${finalPrice.toFixed(2)}`;
            } else {
                document.getElementById('priceOutput').innerText = 'Selecteer een geldig merk en model.';
            }
        }

        window.onload = function () {
            document.getElementById('brand').addEventListener('change', updateModels);
            document.getElementById('model').addEventListener('change', calculatePrice);
            document.querySelectorAll('input[name="condition"]').forEach(el => el.addEventListener('change', calculatePrice));
            document.querySelectorAll('input[name="electronics"]').forEach(el => el.addEventListener('change', calculatePrice));
            document.querySelectorAll('input[name="accessories"]').forEach(el => el.addEventListener('change', calculatePrice));
            document.querySelectorAll('input[name="cleaning"]').forEach(el => el.addEventListener('change', calculatePrice));
        };
    </script>
</head>
<body class="bg-gray-200 p-8">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-lg border border-gray-200">
        <h1 class="text-3xl font-bold mb-8 text-center text-gray-900">Verkoop uw gebruikte koffiezetapparaat</h1>

        <form method="post" action="" class="space-y-6">
            <div>
                <label for="brand" class="block text-gray-700 font-semibold mb-2">Selecteer merk:</label>
                <select id="brand" name="brand" onchange="updateModels()" required class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Kies een merk --</option>
                    <option value="Philips">Philips</option>
                    <option value="Jura">Jura</option>
                    <option value="DeLonghi">DeLonghi</option>
                    <option value="Siemens">Siemens</option>
                    <option value="Sage">Sage</option>
                    <option value="Solis">Solis</option>
                    <option value="Gaggia">Gaggia</option>
                    <option value="Nivona">Nivona</option>
                    <option value="Melitta">Melitta</option>
                    <option value="Saeco">Saeco</option>
                    <option value="Atag">Atag</option>
                    <option value="Miele">Miele</option>
                    <option value="Bauknecht">Bauknecht</option>
                </select>
            </div>

            <div>
                <label for="model" class="block text-gray-700 font-semibold mb-2">Selecteer model:</label>
                <select id="model" name="model" required class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Kies eerst een merk</option>
                </select>
            </div>

            <div>
                <span class="block text-gray-700 font-semibold mb-2">Conditie:</span>
                <div class="space-y-2">
                    <label class="inline-flex items-center">
                        <input type="radio" name="condition" value="100" class="form-radio h-4 w-4 text-blue-600" checked>
                        <span class="ml-2 text-gray-800">Top-staat</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="condition" value="70" class="form-radio h-4 w-4 text-blue-600">
                        <span class="ml-2 text-gray-800">Intensief gebruikt (-30%)</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="condition" value="60" class="form-radio h-4 w-4 text-blue-600">
                        <span class="ml-2 text-gray-800">Reparatie nodig - mechanisch (-40%)</span>
                    </label>
                </div>
            </div>

            <div>
                <span class="block text-gray-700 font-semibold mb-2">Elektronica/Display factor:</span>
                <div class="space-y-2">
                    <label class="inline-flex items-center">
                        <input type="radio" name="electronics" value="0" class="form-radio h-4 w-4 text-blue-600" checked>
                        <span class="ml-2 text-gray-800">Geen problemen</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="electronics" value="-20" class="form-radio h-4 w-4 text-blue-600">
                        <span class="ml-2 text-gray-800">Problemen elektronica (-20%)</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="electronics" value="-20" class="form-radio h-4 w-4 text-blue-600">
                        <span class="ml-2 text-gray-800">Problemen display (-20%)</span>
                    </label>
                </div>
            </div>

            <div>
                <span class="block text-gray-700 font-semibold mb-2">Originele accessoires aanwezig:</span>
                <div class="space-y-2">
                    <label class="inline-flex items-center">
                        <input type="radio" name="accessories" value="0" class="form-radio h-4 w-4 text-blue-600" checked>
                        <span class="ml-2 text-gray-800">Ja</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="accessories" value="-15" class="form-radio h-4 w-4 text-blue-600">
                        <span class="ml-2 text-gray-800">Nee (-15%)</span>
                    </label>
                </div>
            </div>

            <div>
                <span class="block text-gray-700 font-semibold mb-2">Schoonmaakfactor:</span>
                <div class="space-y-2">
                    <label class="inline-flex items-center">
                        <input type="radio" name="cleaning" value="5" class="form-radio h-4 w-4 text-blue-600" checked>
                        <span class="ml-2 text-gray-800">Professioneel gereinigd en ontkalkt (+5%)</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="cleaning" value="2" class="form-radio h-4 w-4 text-blue-600">
                        <span class="ml-2 text-gray-800">Grondig schoongemaakt (+2%)</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="cleaning" value="0" class="form-radio h-4 w-4 text-blue-600">
                        <span class="ml-2 text-gray-800">Oppervlakkig schoongemaakt (0%)</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="cleaning" value="-5" class="form-radio h-4 w-4 text-blue-600">
                        <span class="ml-2 text-gray-800">Niet schoongemaakt en onderhoud nodig (-5%)</span>
                    </label>
                </div>
            </div>
        </form>

        <div id="priceOutput" class="mt-6 p-4 bg-blue-100 border border-blue-300 text-blue-800 rounded-lg shadow-md">
            Selecteer merk, model en condities om de prijs te berekenen.
        </div>
    </div>
</body>
</html>
