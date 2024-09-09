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
        .dynamic-question { display: none; }
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

        function showStep(stepNumber) {
            document.querySelectorAll('.step').forEach(step => step.classList.remove('active'));
            document.getElementById(`step${stepNumber}`).classList.add('active');
        }

        function submitForm() {
            const brand = document.getElementById('brand').value;
            const model = document.getElementById('model').value;
            const machineStatus = document.querySelector('input[name="machine-status"]:checked')?.value || "";
            const electronics = document.querySelector('input[name="electronics"]:checked')?.value || "";
            const accessories = document.querySelector('input[name="accessories"]:checked')?.value || "";
            const cleaning = document.querySelector('input[name="cleaning"]:checked')?.value || "";
            const packaging = document.querySelector('input[name="packaging"]:checked')?.value || "";
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;

            if (brand && model && machineStatus && name && email && phone) {
                const queryParams = `?brand=${encodeURIComponent(brand)}&model=${encodeURIComponent(model)}&machineStatus=${encodeURIComponent(machineStatus)}&electronics=${encodeURIComponent(electronics)}&accessories=${encodeURIComponent(accessories)}&cleaning=${encodeURIComponent(cleaning)}&packaging=${encodeURIComponent(packaging)}&name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&phone=${encodeURIComponent(phone)}`;
                window.location.href = `resultaat.html${queryParams}`;
            } else {
                alert('Vul alle velden in om verder te gaan.');
            }
        }

        function toggleDynamicQuestion() {
            const machineStatus = document.querySelector('input[name="machine-status"]:checked')?.value;
            const electronicsQuestion = document.getElementById('electronicsQuestion');
            if (machineStatus === "repair_needed" || machineStatus === "not_properly_working") {
                electronicsQuestion.style.display = 'block';
            } else {
                electronicsQuestion.style.display = 'none';
            }
        }

        window.onload = function () {
            document.getElementById('brand').addEventListener('change', updateModels);
            document.getElementById('nextStep1').addEventListener('click', () => showStep(2));
            document.getElementById('nextStep2').addEventListener('click', () => showStep(3));
            document.getElementById('submitForm').addEventListener('click', submitForm);
            
            document.querySelectorAll('input[name="machine-status"]').forEach(input => {
                input.addEventListener('change', toggleDynamicQuestion);
            });
        };
    </script>
</head>
<body>
    <div>
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
                    <label>Werkt de machine?</label>
                    <input type="radio" name="machine-status" value="working_well" checked> De machine werkt goed en is in top-staat.
                    <input type="radio" name="machine-status" value="heavily_used"> De machine werkt goed, maar intensief gebruikt.
                    <input type="radio" name="machine-status" value="repair_needed"> De machine werkt, maar heeft reparatie nodig.
                    <input type="radio" name="machine-status" value="not_properly_working"> De machine werkt niet naar behoren.
                </div>

                <div id="electronicsQuestion" class="dynamic-question">
                    <label>Zijn er specifieke problemen met de elektronica of het display?</label>
                    <input type="radio" name="electronics" value="electronics_issue"> Ja, er zijn problemen met de elektronica.
                    <input type="radio" name="electronics" value="display_issue"> Ja, er zijn problemen met het display.
                    <input type="radio" name="electronics" value="mechanical_issue" checked> Nee, de problemen zijn alleen van mechanische aard.
                </div>

                <div>
                    <label>Hoe compleet is de machine?</label>
                    <input type="radio" name="accessories" value="all_present" checked> Alle originele accessoires zijn aanwezig.
                    <input type="radio" name="accessories" value="some_missing"> Niet alle originele accessoires zijn aanwezig.
                </div>

                <div>
                    <label>Schoonmaakstatus van de machine</label>
                    <input type="radio" name="cleaning" value="professionally_cleaned" checked> De machine is professioneel gereinigd en ontkalkt.
                    <input type="radio" name="cleaning" value="thoroughly_cleaned"> De machine is grondig schoongemaakt.
                    <input type="radio" name="cleaning" value="superficially_cleaned"> De machine heeft een oppervlakkige schoonmaak gehad.
                    <input type="radio" name="cleaning" value="needs_maintenance"> De machine is niet schoongemaakt en heeft onderhoud nodig.
                </div>

                <div>
                    <label>Verzendopties</label>
                    <input type="radio" name="packaging" value="original_box" checked> Ik kan mijn machine verzenden in de originele doos.
                    <input type="radio" name="packaging" value="self_packaging"> Ik kan mijn machine zelf verpakken.
                    <input type="radio" name="packaging" value="request_packaging"> Ik ontvang graag verpakkingsmateriaal.
                </div>

                <button type="button" id="nextStep2">Volgende stap</button>
            </form>
        </div>

        <!-- Step 3: Personal Information -->
        <div id="step3" class="step">
                <div>
                    <label for="name">Naam:</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div>
                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div>
                    <label for="phone">Telefoonnummer:</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>

                <a href="resultaat.html" id="submitForm" class="button-link">Bereken prijs</a>
                </form>
            
            </form>
        </div>
    </div>
</body>
</html>
