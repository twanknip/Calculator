<?php
// Database Connection
$servername = "localhost";
$username = "root"; // Change this as needed
$password = ""; // Change this as needed
$dbname = "mkv_form"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to fetch all brandsdfsf
function fetchBrands($conn) {
    $sql = "SELECT * FROM brands";
    $result = $conn->query($sql);

    $brands = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $brands[] = $row;
        }
    }
    return $brands;
}

// Function to fetch models by brand ID (used for AJAX)
function fetchModelsByBrandId($conn, $brand_id) {
    $sql = "SELECT * FROM models WHERE brand_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $brand_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $models = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $models[] = $row;
        }
    }
    $stmt->close();
    return $models;
}

// Check if an AJAX request is made to get models by brand ID
if (isset($_GET['brand_id'])) {
    $brand_id = $_GET['brand_id'];
    $models = fetchModelsByBrandId($conn, $brand_id);
    echo json_encode($models);
    exit; // Exit after handling the AJAX request
}

// Fetch all brands for the initial page load
$brands = fetchBrands($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Machine Selector</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .questionnaire {
            display: none; /* Initially hide the questionnaire */
        }
        .dynamic-question {
            display: none; /* Initially hide dynamic questions */
        }
    </style>
    <script>
        // Function to fetch models based on selected brand
        function fetchModelsByBrand(brandId) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "?brand_id=" + brandId, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var models = JSON.parse(xhr.responseText);
                    var modelSelect = document.getElementById("modelSelect");
                    modelSelect.innerHTML = '<option value="">Select Model</option>';
                    models.forEach(function (model) {
                        var option = document.createElement("option");
                        option.value = model.id;
                        option.text = model.name;
                        modelSelect.appendChild(option);
                    });
                }
            };
            xhr.send();
        }

        // Event listener for brand dropdown change
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("brandSelect").addEventListener("change", function () {
                var brandId = this.value;
                if (brandId) {
                    fetchModelsByBrand(brandId);
                } else {
                    document.getElementById("modelSelect").innerHTML = '<option value="">Select Model</option>';
                }
            });

            // Show questionnaire after selecting a model
            document.getElementById("modelSelect").addEventListener("change", function () {
                var modelId = this.value;
                if (modelId) {
                    document.querySelector(".questionnaire").style.display = 'block';
                } else {
                    document.querySelector(".questionnaire").style.display = 'none';
                }
            });

            // Show dynamic question based on machine status choice
            document.getElementsByName("machine_status").forEach(function (radio) {
                radio.addEventListener("change", function () {
                    if (this.value === "needs_repair" || this.value === "not_working") {
                        document.querySelector(".dynamic-question").style.display = 'block';
                    } else {
                        document.querySelector(".dynamic-question").style.display = 'none';
                    }
                });
            });
        });
    </script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="container mx-auto p-6">
        <h2 class="text-3xl font-bold mb-6 text-center">Select a Brand and Model</h2>
        <form action="process_form.php" method="post" class="bg-white shadow-md rounded-lg p-6">
            <!-- Brand Dropdown -->
            <div class="mb-4">
                <label for="brandSelect" class="block text-lg font-medium text-gray-700">Brand:</label>
                <select id="brandSelect" name="brand" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Select Brand</option>
                    <?php foreach ($brands as $brand): ?>
                        <option value="<?php echo $brand['id']; ?>"><?php echo $brand['name']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Model Dropdown -->
            <div class="mb-4">
                <label for="modelSelect" class="block text-lg font-medium text-gray-700">Model:</label>
                <select id="modelSelect" name="model" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    <option value="">Select Model</option>
                    <!-- Models will be populated dynamically using JavaScript -->
                </select>
            </div>

            <!-- Questionnaire Section -->
            <div class="questionnaire mt-6">
                <h3 class="text-2xl font-semibold mb-4">Vragenlijst voor de Koffiemachine</h3>
                
                <!-- Machine Status Question -->
                <fieldset class="mb-4">
                    <legend class="text-lg font-medium text-gray-700">Werkt de machine?</legend>
                    <div class="mt-2 space-y-2">
                        <label class="flex items-center"><input type="radio" name="machine_status" value="working_good" class="mr-2">De machine werkt goed en is in top-staat.</label>
                        <label class="flex items-center"><input type="radio" name="machine_status" value="working_intensively" class="mr-2">De machine werkt goed, maar intensief gebruikt.</label>
                        <label class="flex items-center"><input type="radio" name="machine_status" value="needs_repair" class="mr-2">De machine werkt, maar heeft reparatie nodig.</label>
                        <label class="flex items-center"><input type="radio" name="machine_status" value="not_working" class="mr-2">De machine werkt niet naar behoren.</label>
                    </div>
                </fieldset>

                <!-- Dynamic Follow-up Question -->
                <div class="dynamic-question mb-4">
                    <fieldset>
                        <legend class="text-lg font-medium text-gray-700">Zijn er specifieke problemen met de elektronica of het display?</legend>
                        <div class="mt-2 space-y-2">
                            <label class="flex items-center"><input type="radio" name="electronic_issues" value="electronic_problems" class="mr-2">Ja, er zijn problemen met de elektronica (bijv. machine schakelt zichzelf uit, reageert niet goed).</label>
                            <label class="flex items-center"><input type="radio" name="electronic_issues" value="display_problems" class="mr-2">Ja, er zijn problemen met het display (bijv. display werkt niet, vertoont strepen).</label>
                            <label class="flex items-center"><input type="radio" name="electronic_issues" value="mechanical_problems" class="mr-2">Nee, de problemen zijn alleen van mechanische aard.</label>
                        </div>
                    </fieldset>
                </div>

                <!-- Completeness of the Machine -->
                <fieldset class="mb-4">
                    <legend class="text-lg font-medium text-gray-700">Hoe compleet is de machine?</legend>
                    <div class="mt-2 space-y-2">
                        <label class="flex items-center"><input type="radio" name="completeness" value="all_accessories" class="mr-2">Alle originele accessoires zijn aanwezig.</label>
                        <label class="flex items-center"><input type="radio" name="completeness" value="not_all_accessories" class="mr-2">Niet alle originele accessoires zijn aanwezig.</label>
                    </div>
                </fieldset>

                <!-- Cleaning Status -->
                <fieldset class="mb-4">
                    <legend class="text-lg font-medium text-gray-700">Schoonmaakstatus van de machine</legend>
                    <div class="mt-2 space-y-2">
                        <label class="flex items-center"><input type="radio" name="cleaning_status" value="professionally_cleaned" class="mr-2">De machine is professioneel gereinigd en ontkalkt.</label>
                        <label class="flex items-center"><input type="radio" name="cleaning_status" value="thoroughly_cleaned" class="mr-2">De machine is grondig schoongemaakt.</label>
                        <label class="flex items-center"><input type="radio" name="cleaning_status" value="lightly_cleaned" class="mr-2">De machine heeft een oppervlakkige schoonmaak gehad.</label>
                        <label class="flex items-center"><input type="radio" name="cleaning_status" value="not_cleaned" class="mr-2">De machine is niet schoongemaakt en heeft onderhoud nodig.</label>
                    </div>
                </fieldset>

                <!-- Shipping Options -->
                <fieldset class="mb-6">
                    <legend class="text-lg font-medium text-gray-700">Verzendopties</legend>
                    <div class="mt-2 space-y-2">
                        <label class="flex items-center"><input type="radio" name="shipping_options" value="original_box" class="mr-2">Ik kan mijn machine verzenden in de originele doos.</label>
                        <label class="flex items-center"><input type="radio" name="shipping_options" value="self_packaging" class="mr-2">Ik kan mijn machine zelf verpakken.</label>
                        <label class="flex items-center"><input type="radio" name="shipping_options" value="need_packaging" class="mr-2">Ik ontvang graag verpakkingsmateriaal.</label>
                    </div>
                </fieldset>

                <!-- Submit Button -->
                <div class="flex justify-center">
                    <input type="submit" value="Submit" class="bg-indigo-600 text-white py-2 px-4 rounded-lg shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                </div>
            </div>
        </form>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
