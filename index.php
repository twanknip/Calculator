<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Koffiezetapparaat Verkoop</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .step { display: none; }
        .step.active { display: block; }
        #loading { display: none; }
    </style>
    <script>
        const models = {
            "Philips": ["EP 2300 series", "EP 3300 series", "EP 4300 series", "EP 4400 series", "EP 5300 series", "EP 5400 series", "EP 5500 series"],
            "Jura": ["A series", "D series", "Ena series", "Ena 8", "E series", "F series", "GIGA series", "GIGA X7C", "GIGA X series", "GIGA 10 series", "X series", "XF series", "S series", "XS series", "J 5 tm 7 series", "J8", "J9 & J10 series", "WE series", "Z5", "Z6", "Z7"],
            "DeLonghi": ["Dinamica series", "Primadonna series", "Primadonna Elite series", "Primadonna Exclusive series", "Eletta series", "Maestosa series", "Cappuccino series"],
            "Siemens": ["EQ6 S100", "EQ6 PLUS S100", "EQ6 S300", "EQ6 PLUS S300", "EQ6 S400", "EQ6 PLUS S400", "EQ6 S500", "EQ6 PLUS S500", "EQ6 S700", "EQ6 PLUS S700", "EQ6 S800", "EQ6 PLUS EXTRA KLASSE", "EQ9 series", "Inbouw machines"],
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
            "Philips": {
                "EP 2300 series": 70,
                "EP 3300 series": 80,
                "EP 4300 series": 125,
                "EP 4400 series": 125,
                "EP 5300 series": 80,
                "EP 5400 series": 150,
                "EP 5500 series": 125
            },
            "Jura": {
                "A series": 80,
                "D series": 150,
                "Ena series": 100,
                "Ena 8": 125,
                "E series": 150,
                "F series": 130,
                "GIGA series": 425,
                "GIGA X7C": 425,
                "GIGA X series": 700,
                "GIGA 10 series": 700,
                "X series": 700,
                "XF series": 150,
                "S series": 200,
                "XS series": 200,
                "J 5 tm 7 series": 125,
                "J8": 450,
                "J9 & J10 series": 175,
                "S series": 175,
                "WE series": 200,
                "Z5": 200,
                "Z6": 350,
                "Z7": 350
            },
            // Voeg overige merken en modellen hier toe
        };

        function updateModels() {
            const brandSelect = document.getElementById('brand');
            const modelSelect = document.getElementById('model');
            const selectedBrand = brandSelect.value;

            modelSelect.innerHTML = '';

            if (models[selectedBrand]) {
                models[selectedBrand].forEach(model => {
                    const option = document.createElement('option');
                    option.value = model;
                    option.text = model;
                    modelSelect.add(option);
                });
                modelSelect.disabled = false;
            } else {
                modelSelect.disabled = true;
                const option = document.createElement('option');
                option.value = '';
                option.text = 'Kies eerst een merk';
                modelSelect.add(option);
            }
        }

        function submitForm() {
            const brand = document.getElementById('brand').value;
            const model = document.getElementById('model').value;
            const condition = document.querySelector('input[name="condition"]:checked')?.value || 100;
            const electronics = document.querySelector('input[name="electronics"]:checked')?.value || 0;
            const accessories = document.querySelector('input[name="accessories"]:checked')?.value || 0;
            const cleaning = document.querySelector('input[name="cleaning"]:checked')?.value || 0;

            if (brand && model) {
                const queryParams = `?brand=${encodeURIComponent(brand)}&model=${encodeURIComponent(model)}&condition=${encodeURIComponent(condition)}&electronics=${encodeURIComponent(electronics)}&accessories=${encodeURIComponent(accessories)}&cleaning=${encodeURIComponent(cleaning)}`;
                window.location.href = `resultaat.html${queryParams}`;
            } else {
                alert('Selecteer een merk en model om verder te gaan.');
            }
        }

        function showStep(stepNumber) {
            document.querySelectorAll('.step').forEach(step => step.classList.remove('active'));
            document.getElementById(`step${stepNumber}`).classList.add('active');
        }

        window.onload = function () {
            document.getElementById('brand').addEventListener('change', updateModels);
            document.getElementById('nextStep1').addEventListener('click', () => showStep(2));
            document.getElementById('submitForm').addEventListener('click', submitForm);
        };
    </script>
</head>
<body>
    <div>
        <h1>Verkoop uw gebruikte koffiezetapparaat</h1>

        <!-- Step 1: Select Brand and Model -->
        <div id="step1" class="step active">
            <form id="formStep1">
                <div>
                    <label for="brand">Selecteer merk:</label>
                    <select id="brand" name="brand" required>
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
                    <label for="model">Selecteer model:</label>
                    <select id="model" name="model" required disabled>
                        <option value="">Kies eerst een merk</option>
                    </select>
                </div>

                <button type="button" id="nextStep1">Volgende stap</button>
            </form>
        </div>

        <!-- Step 2: Options for Condition, Electronics, Accessories, and Cleaning -->
        <div id="step2" class="step">
            <form id="formStep2">
                <div>
                    <span>Conditie:</span>
                    <div>
                        <label>
                            <input type="radio" name="condition" value="100" checked>
                            Top-staat
                        </label>
                        <label>
                            <input type="radio" name="condition" value="70">
                            Intensief gebruikt 
                        </label>
                        <label>
                            <input type="radio" name="condition" value="60">
                            Reparatie nodig - mechanisch
                        </label>
                    </div>
                </div>

                <div>
                    <span>Elektronica/Display factor:</span>
                    <div>
                        <label>
                            <input type="radio" name="electronics" value="0" checked>
                            Geen problemen
                        </label>
                        <label>
                            <input type="radio" name="electronics" value="-20">
                            Problemen elektronica 
                        </label>
                        <label>
                            <input type="radio" name="electronics" value="-20">
                            Problemen display 
                        </label>
                    </div>
                </div>

                <div>
                    <span>Originele accessoires aanwezig:</span>
                    <div>
                        <label>
                            <input type="radio" name="accessories" value="0" checked>
                            Ja
                        </label>
                        <label>
                            <input type="radio" name="accessories" value="-15">
                            Nee 
                        </label>
                    </div>
                </div>

                <div>
                    <span>Schoonmaakfactor:</span>
                    <div>
                        <label>
                            <input type="radio" name="cleaning" value="5" checked>
                            Professioneel gereinigd en ontkalkt 
                        </label>
                        <label>
                            <input type="radio" name="cleaning" value="2">
                            Grondig schoongemaakt 
                        </label>
                        <label>
                            <input type="radio" name="cleaning" value="0">
                            Oppervlakkig schoongemaakt 
                        </label>
                        <label>
                            <input type="radio" name="cleaning" value="-5">
                            Niet schoongemaakt en onderhoud nodig 
                        </label>
                    </div>
                </div>

                <button type="button" id="submitForm">Prijs berekenen</button>
            </form>
        </div>
    </div>
</body>
</html>
