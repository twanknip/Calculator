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
        let models = {};

        function fetchBrandAndModelData() {
            fetch('fetch_data.php')
                .then(response => response.json())
                .then(data => {
                    populateBrands(data.brands);
                    models = data.models;
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        function populateBrands(brands) {
            const brandSelect = document.getElementById('brand');
            brandSelect.innerHTML = '<option value="">-- Kies een merk --</option>';
            brands.forEach(brand => {
                const option = document.createElement('option');
                option.value = brand;
                option.text = brand;
                brandSelect.add(option);
            });
        }

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
            fetchBrandAndModelData();
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
    <!-- Rest of your HTML remains unchanged -->
    <!-- Step 1: Select Brand and Model -->
    <div id="step1" class="step active">
        <!-- Step 1 form content -->
    </div>

    <!-- Step 2: Options for Condition, Electronics, Accessories, and Cleaning -->
    <div id="step2" class="step">
        <!-- Step 2 form content -->
    </div>

    <!-- Step 3: Personal Information -->
    <div id="step3" class="step">
        <!-- Step 3 form content -->
    </div>
</body>
</html>
