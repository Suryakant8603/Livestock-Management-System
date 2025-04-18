<?php
session_start();
if (!isset($_SESSION["loggedin"])) {
    header("Location: login.php");
    exit;
}
$username = ucfirst($_SESSION["username"]);
$date = date("l, F j, Y");
$time = date("h:i A");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Welcome <?= htmlspecialchars($username); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

  <!-- Header -->
  <header class="bg-white shadow-md py-4 px-6 flex flex-col md:flex-row justify-between items-center">
    <!-- Left: Welcome -->
    <div class="text-2xl font-semibold text-gray-800">
      👋 Welcome, <span class="text-blue-600"><?= $username ?></span>
    </div>

    <!-- Center: Date & Time -->
    <div class="text-sm text-gray-500 mt-2 md:mt-0">
      📅 <?= $date ?> | ⏰ <?= $time ?>
    </div>

    <!-- Right: Logout Button -->
    <div class="mt-2 md:mt-0">
      <a href="logout.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-full text-sm font-medium transition duration-200">
        Logout
      </a>
    </div>
  </header>

  <!-- Main Content -->
  <main class="max-w-4xl mx-auto mt-10 bg-white p-8 rounded-lg shadow-lg text-center">
    <h2 class="text-3xl font-bold text-gray-800 mb-4">Welcome to Your Dashboard, <?= $username ?>!</h2>
    <p class="text-gray-600">Here you can manage your account, view insights, and much more.</p>
  </main>

</body>
</html>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livestock Management System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }
        .page {
            display: none;
        }
        .page.active {
            display: block;
        }
        .menu-item {
            cursor: pointer;
            transition: all 0.3s;
        }
        .menu-item.active {
            background-color: #E3F2FD;
            color: #1E40AF;
            font-weight: 600;
        }
        /* Optimize for PDF export - prevent page breaks */
        @media print {
            body, html {
                height: auto;
                margin: 0;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold text-gray-800">Livestock Manager</h2>
                <p class="text-sm text-gray-500">Manage your farm efficiently</p>
                <a href="login.php" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Login</a>
            </div>
            <ul class="mt-6 space-y-2">
                <li class="menu-item px-4 py-2 active" data-page="dashboard">
                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                </li>
                <li class="menu-item px-4 py-2 hover:bg-gray-200" data-page="animals">
                    <i class="fas fa-horse mr-2"></i> Animal Inventory
                </li>
                <li class="menu-item px-4 py-2 hover:bg-gray-200" data-page="health">
                    <i class="fas fa-heartbeat mr-2"></i> Health Records
                </li>
                <li class="menu-item px-4 py-2 hover:bg-gray-200" data-page="feeding">
                    <i class="fas fa-utensils mr-2"></i> Feeding Schedule
                </li>
                <li class="menu-item px-4 py-2 hover:bg-gray-200" data-page="reports">
                    <i class="fas fa-chart-bar mr-2"></i> Reports
                </li>
            </ul>
        </aside>
      
        <!-- Main Content -->
        <main class="flex-1 p-6">
            <!-- Dashboard Page -->
            <section id="dashboard" class="page active space-y-6">
                <h1 class="text-2xl font-bold">Dashboard</h1>
          
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white p-4 rounded shadow">
                        <h3 class="text-gray-700">Total Animals</h3>
                        <div class="text-2xl font-bold" id="total-animals">0</div>
                    </div>
                    <div class="bg-white p-4 rounded shadow">
                        <h3 class="text-gray-700">Health Alerts</h3>
                        <div class="text-2xl font-bold" id="health-alerts">0</div>
                    </div>
                    <div class="bg-white p-4 rounded shadow">
                        <h3 class="text-gray-700">Feeding Today</h3>
                        <div class="text-2xl font-bold" id="feeding-today">0</div>
                    </div>
                    <div class="bg-white p-4 rounded shadow">
                        <h3 class="text-gray-700">Costs This Month</h3>
                        <div class="text-2xl font-bold" id="monthly-costs">$0</div>
                    </div>
                </div>
          
                <div class="bg-white p-6 rounded shadow">
                    <h2 class="text-xl font-semibold mb-4">Animal Distribution by Species</h2>
                    <div id="species-chart" class="h-72 flex items-center justify-center bg-gray-100">
                        <div class="text-center">
                            <div class="flex justify-center space-x-4">
                                <div class="text-center">
                                    <div class="w-24 h-24 rounded-full bg-blue-500 flex items-center justify-center text-white text-xl font-bold">45%</div>
                                    <p class="mt-2">Cattle</p>
                                </div>
                                <div class="text-center">
                                    <div class="w-20 h-20 rounded-full bg-green-500 flex items-center justify-center text-white text-xl font-bold">25%</div>
                                    <p class="mt-2">Sheep</p>
                                </div>
                                <div class="text-center">
                                    <div class="w-16 h-16 rounded-full bg-yellow-500 flex items-center justify-center text-white text-xl font-bold">15%</div>
                                    <p class="mt-2">Pigs</p>
                                </div>
                                <div class="text-center">
                                    <div class="w-12 h-12 rounded-full bg-red-500 flex items-center justify-center text-white text-lg font-bold">10%</div>
                                    <p class="mt-2">Chickens</p>
                                </div>
                                <div class="text-center">
                                    <div class="w-8 h-8 rounded-full bg-purple-500 flex items-center justify-center text-white text-xs font-bold">5%</div>
                                    <p class="mt-2">Other</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
          
                <div class="bg-white p-6 rounded shadow">
                    <h2 class="text-xl font-semibold mb-4">Recent Activities</h2>
                    <div id="activity-list" class="space-y-2">
                        <div class="text-sm text-gray-700 p-2 hover:bg-gray-50 rounded"><strong>Today 10:30 AM</strong> - New cow added to inventory</div>
                        <div class="text-sm text-gray-700 p-2 hover:bg-gray-50 rounded"><strong>Yesterday 2:15 PM</strong> - Vaccination scheduled for pigs</div>
                        <div class="text-sm text-gray-700 p-2 hover:bg-gray-50 rounded"><strong>Feb 15, 2023</strong> - Updated feeding schedule for cattle</div>
                        <div class="text-sm text-gray-700 p-2 hover:bg-gray-50 rounded"><strong>Feb 14, 2023</strong> - Health check completed for all animals</div>
                        <div class="text-sm text-gray-700 p-2 hover:bg-gray-50 rounded"><strong>Feb 13, 2023</strong> - Monthly expense report generated</div>
                    </div>
                </div>
            </section>
          
            <!-- Animal Inventory Page -->
            <section id="animals" class="page space-y-6">
                <h1 class="text-2xl font-bold">Animal Inventory</h1>
          
                <div class="bg-green-100 border border-green-400 text-green-700 p-4 rounded hidden" id="animal-success-alert">
                    Operation completed successfully!
                </div>
          
                <div class="bg-white p-6 rounded shadow">
                    <h2 class="text-xl font-semibold mb-4">Add New Animal</h2>
                    <form id="add-animal-form" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium">ID/Tag Number</label>
                            <input type="text" id="animal-id" class="w-full border p-2 rounded" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Animal Type</label>
                            <select id="animal-type" class="w-full border p-2 rounded" required>
                                <option value="">Select Type</option>
                                <option value="Cattle">Cattle</option>
                                <option value="Sheep">Sheep</option>
                                <option value="Goat">Goat</option>
                                <option value="Pig">Pig</option>
                                <option value="Chicken">Chicken</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Breed</label>
                            <input type="text" id="animal-breed" class="w-full border p-2 rounded" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Date of Birth/Acquisition</label>
                            <input type="date" id="animal-dob" class="w-full border p-2 rounded" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Gender</label>
                            <select id="animal-gender" class="w-full border p-2 rounded" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Weight (kg)</label>
                            <input type="number" id="animal-weight" step="0.01" class="w-full border p-2 rounded" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium">Notes</label>
                            <textarea id="animal-notes" rows="3" class="w-full border p-2 rounded"></textarea>
                        </div>
                        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Add Animal</button>
                    </form>
                </div>
          
                <div class="bg-white p-6 rounded shadow">
                    <h2 class="text-xl font-semibold mb-4">Animal Inventory List</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full border text-sm" id="animals-table">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="p-2 border">ID/Tag</th>
                                    <th class="p-2 border">Type</th>
                                    <th class="p-2 border">Breed</th>
                                    <th class="p-2 border">DOB/Acquired</th>
                                    <th class="p-2 border">Gender</th>
                                    <th class="p-2 border">Weight (kg)</th>
                                    <th class="p-2 border">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="p-2 border">A001</td>
                                    <td class="p-2 border">Cattle</td>
                                    <td class="p-2 border">Holstein</td>
                                    <td class="p-2 border">2020-04-15</td>
                                    <td class="p-2 border">Female</td>
                                    <td class="p-2 border">650</td>
                                    <td class="p-2 border space-x-2">
                                        <button class="text-blue-500 hover:underline edit-btn" data-id="A001"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-500 hover:underline delete-btn" data-id="A001"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-2 border">A002</td>
                                    <td class="p-2 border">Sheep</td>
                                    <td class="p-2 border">Merino</td>
                                    <td class="p-2 border">2021-02-10</td>
                                    <td class="p-2 border">Male</td>
                                    <td class="p-2 border">75</td>
                                    <td class="p-2 border space-x-2">
                                        <button class="text-blue-500 hover:underline edit-btn" data-id="A002"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-500 hover:underline delete-btn" data-id="A002"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="p-2 border">A003</td>
                                    <td class="p-2 border">Pig</td>
                                    <td class="p-2 border">Yorkshire</td>
                                    <td class="p-2 border">2021-07-22</td>
                                    <td class="p-2 border">Female</td>
                                    <td class="p-2 border">120</td>
                                    <td class="p-2 border space-x-2">
                                        <button class="text-blue-500 hover:underline edit-btn" data-id="A003"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-500 hover:underline delete-btn" data-id="A003"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Health Records Page -->
            <section id="health" class="page space-y-8">
                <h1 class="text-3xl font-bold text-gray-800">Health Records</h1>

                <div class="bg-green-100 text-green-800 px-4 py-2 rounded hidden" id="health-success-alert">
                    Health record saved successfully!
                </div>

                <!-- Add Health Record -->
                <div class="bg-white shadow rounded p-6 space-y-4">
                    <h2 class="text-xl font-semibold text-gray-700">Add Health Record</h2>
                    <form id="add-health-form" class="space-y-4">
                        <div>
                            <label for="health-animal-id" class="block font-medium">Animal ID/Tag</label>
                            <select id="health-animal-id" class="mt-1 w-full p-2 border rounded" required>
                                <option value="">Select Animal</option>
                                <option value="A001">A001 - Holstein Cow</option>
                                <option value="A002">A002 - Merino Sheep</option>
                                <option value="A003">A003 - Yorkshire Pig</option>
                            </select>
                        </div>
                        <div>
                            <label for="health-date" class="block font-medium">Date</label>
                            <input type="date" id="health-date" class="mt-1 w-full p-2 border rounded" required>
                        </div>
                        <div>
                            <label for="health-type" class="block font-medium">Record Type</label>
                            <select id="health-type" class="mt-1 w-full p-2 border rounded" required>
                                <option value="">Select Type</option>
                                <option value="Vaccination">Vaccination</option>
                                <option value="Treatment">Treatment</option>
                                <option value="Checkup">Routine Checkup</option>
                                <option value="Illness">Illness</option>
                                <option value="Injury">Injury</option>
                            </select>
                        </div>
                        <div>
                            <label for="health-description" class="block font-medium">Description</label>
                            <textarea id="health-description" rows="3" class="mt-1 w-full p-2 border rounded" required></textarea>
                        </div>
                        <div>
                            <label for="health-treatment" class="block font-medium">Treatment/Medicine</label>
                            <input type="text" id="health-treatment" class="mt-1 w-full p-2 border rounded">
                        </div>
                        <div>
                            <label for="health-cost" class="block font-medium">Cost</label>
                            <input type="number" id="health-cost" step="0.01" class="mt-1 w-full p-2 border rounded">
                        </div>
                        <div>
                            <label for="health-next-followup" class="block font-medium">Next Follow-up Date</label>
                            <input type="date" id="health-next-followup" class="mt-1 w-full p-2 border rounded">
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save Record</button>
                    </form>
                </div>

                <!-- Health Records Table -->
                <div class="bg-white shadow rounded p-6">
                    <h2 class="text-xl font-semibold mb-4">Health Records List</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto border border-gray-200 text-sm" id="health-table">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-2 border">Animal ID</th>
                                    <th class="px-4 py-2 border">Date</th>
                                    <th class="px-4 py-2 border">Type</th>
                                    <th class="px-4 py-2 border">Description</th>
                                    <th class="px-4 py-2 border">Treatment</th>
                                    <th class="px-4 py-2 border">Cost</th>
                                    <th class="px-4 py-2 border">Next Follow-up</th>
                                    <th class="px-4 py-2 border">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">A001</td>
                                    <td class="px-4 py-2 border">2023-01-15</td>
                                    <td class="px-4 py-2 border">Vaccination</td>
                                    <td class="px-4 py-2 border">Annual vaccination against common diseases</td>
                                    <td class="px-4 py-2 border">Vaccine XYZ</td>
                                    <td class="px-4 py-2 border">$45.00</td>
                                    <td class="px-4 py-2 border">2024-01-15</td>
                                    <td class="px-4 py-2 border space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800 edit-btn" data-index="0"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-600 hover:text-red-800 delete-btn" data-index="0"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">A002</td>
                                    <td class="px-4 py-2 border">2023-02-10</td>
                                    <td class="px-4 py-2 border">Treatment</td>
                                    <td class="px-4 py-2 border">Treated for minor wound on left leg</td>
                                    <td class="px-4 py-2 border">Antibiotics</td>
                                    <td class="px-4 py-2 border">$25.00</td>
                                    <td class="px-4 py-2 border">2023-02-17</td>
                                    <td class="px-4 py-2 border space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800 edit-btn" data-index="1"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-600 hover:text-red-800 delete-btn" data-index="1"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">A003</td>
                                    <td class="px-4 py-2 border">2023-02-20</td>
                                    <td class="px-4 py-2 border">Checkup</td>
                                    <td class="px-4 py-2 border">Routine health checkup - all parameters normal</td>
                                    <td class="px-4 py-2 border">N/A</td>
                                    <td class="px-4 py-2 border">$30.00</td>
                                    <td class="px-4 py-2 border">2023-08-20</td>
                                    <td class="px-4 py-2 border space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800 edit-btn" data-index="2"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-600 hover:text-red-800 delete-btn" data-index="2"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

           <!-- Feeding Schedule Page -->
            <section id="feeding" class="page space-y-8">
                <h1 class="text-3xl font-bold text-gray-800">Feeding Schedule</h1>

                <div class="bg-green-100 text-green-800 px-4 py-2 rounded hidden" id="feeding-success-alert">
                    Feeding schedule updated successfully!
                </div>

                <!-- Feeding Form -->
                <div class="bg-white shadow rounded p-6 space-y-4">
                    <h2 class="text-xl font-semibold text-gray-700">Create Feeding Schedule</h2>
                    <form id="add-feeding-form" class="space-y-4">
                        <div>
                            <label for="feeding-group" class="block font-medium">Animal Group</label>
                            <select id="feeding-group" class="mt-1 w-full p-2 border rounded" required>
                                <option value="">Select Group</option>
                                <option value="Cattle">Cattle</option>
                                <option value="Sheep">Sheep</option>
                                <option value="Pigs">Pigs</option>
                                <option value="Chickens">Chickens</option>
                            </select>
                        </div>
                        <div>
                            <label for="feeding-time" class="block font-medium">Feeding Time</label>
                            <select id="feeding-time" class="mt-1 w-full p-2 border rounded" required>
                                <option value="">Select Time</option>
                                <option value="Morning">Morning</option>
                                <option value="Noon">Noon</option>
                                <option value="Evening">Evening</option>
                            </select>
                        </div>
                        <div>
                            <label for="feeding-feed-type" class="block font-medium">Feed Type</label>
                            <input type="text" id="feeding-feed-type" class="mt-1 w-full p-2 border rounded" required>
                        </div>
                        <div>
                            <label for="feeding-quantity" class="block font-medium">Quantity per Animal (kg)</label>
                            <input type="number" id="feeding-quantity" step="0.01" class="mt-1 w-full p-2 border rounded" required>
                        </div>
                        <div>
                            <label for="feeding-notes" class="block font-medium">Notes/Instructions</label>
                            <textarea id="feeding-notes" rows="3" class="mt-1 w-full p-2 border rounded"></textarea>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Save Schedule</button>
                    </form>
                </div>

                <!-- Feeding Table -->
                <div class="bg-white shadow rounded p-6">
                    <h2 class="text-xl font-semibold mb-4">Feeding Schedules</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto border border-gray-200 text-sm" id="feeding-table">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-2 border">Animal Group</th>
                                    <th class="px-4 py-2 border">Feeding Time</th>
                                    <th class="px-4 py-2 border">Feed Type</th>
                                    <th class="px-4 py-2 border">Quantity (kg)</th>
                                    <th class="px-4 py-2 border">Notes</th>
                                    <th class="px-4 py-2 border">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">Cattle</td>
                                    <td class="px-4 py-2 border">Morning</td>
                                    <td class="px-4 py-2 border">Hay Mix</td>
                                    <td class="px-4 py-2 border">5.00</td>
                                    <td class="px-4 py-2 border">Mix with vitamin supplement</td>
                                    <td class="px-4 py-2 border space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800 edit-btn" data-index="0"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-600 hover:text-red-800 delete-btn" data-index="0"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">Cattle</td>
                                    <td class="px-4 py-2 border">Evening</td>
                                    <td class="px-4 py-2 border">Grain Mix</td>
                                    <td class="px-4 py-2 border">3.50</td>
                                    <td class="px-4 py-2 border">Add mineral supplements</td>
                                    <td class="px-4 py-2 border space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800 edit-btn" data-index="1"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-600 hover:text-red-800 delete-btn" data-index="1"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">Pigs</td>
                                    <td class="px-4 py-2 border">Morning</td>
                                    <td class="px-4 py-2 border">Pig Feed</td>
                                    <td class="px-4 py-2 border">2.00</td>
                                    <td class="px-4 py-2 border">Ensure clean water available</td>
                                    <td class="px-4 py-2 border space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800 edit-btn" data-index="2"><i class="fas fa-edit"></i></button>
                                        <button class="text-red-600 hover:text-red-800 delete-btn" data-index="2"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Reports Page -->
            <section id="reports" class="page space-y-10">
                <h1 class="text-3xl font-bold text-gray-800">Reports</h1>
            
                <!-- Generate Report -->
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h2 class="text-2xl font-semibold mb-4">Generate Report</h2>
                    <form id="generate-report-form" class="space-y-4">
                        <div>
                            <label for="report-type" class="block text-sm font-medium text-gray-700 mb-1">Report Type</label>
                            <select id="report-type" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                <option value="">Select Report Type</option>
                                <option value="inventory">Inventory Summary</option>
                                <option value="health">Health Records</option>
                                <option value="expenses">Expenses Report</option>
                                <option value="productivity">Productivity Report</option>
                            </select>
                        </div>
                        <div>
                            <label for="report-date-from" class="block text-sm font-medium text-gray-700 mb-1">Date From</label>
                            <input type="date" id="report-date-from" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label for="report-date-to" class="block text-sm font-medium text-gray-700 mb-1">Date To</label>
                            <input type="date" id="report-date-to" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">Generate Report</button>
                    </form>
                </div>
            
                <!-- Expense Breakdown -->
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h2 class="text-2xl font-semibold mb-4">Expense Breakdown</h2>
                    <div id="expense-chart" class="h-72 bg-gray-100 flex items-center justify-center">
                        <div class="w-full max-w-lg">
                            <div class="relative pt-1">
                                <div class="flex mb-2 items-center justify-between">
                                    <div>
                                        <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-200">
                                            Feed
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs font-semibold inline-block text-blue-600">
                                            45%
                                        </span>
                                    </div>
                                </div>
                                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200">
                                    <div style="width:45%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"></div>
                                </div>
                                <div class="flex mb-2 items-center justify-between">
                                    <div>
                                        <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-green-600 bg-green-200">
                                            Medical
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs font-semibold inline-block text-green-600">
                                            25%
                                        </span>
                                    </div>
                                </div>
                                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-green-200">
                                    <div style="width:25%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-green-500"></div>
                                </div>
                                <div class="flex mb-2 items-center justify-between">
                                    <div>
                                        <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-red-600 bg-red-200">
                                            Labor
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs font-semibold inline-block text-red-600">
                                            20%
                                        </span>
                                    </div>
                                </div>
                                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-red-200">
                                    <div style="width:20%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-500"></div>
                                </div>
                                <div class="flex mb-2 items-center justify-between">
                                    <div>
                                        <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-yellow-600 bg-yellow-200">
                                            Equipment
                                        </span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs font-semibold inline-block text-yellow-600">
                                            10%
                                        </span>
                                    </div>
                                </div>
                                <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-yellow-200">
                                    <div style="width:10%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-yellow-500"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Animal Health Status -->
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h2 class="text-2xl font-semibold mb-4">Animal Health Status</h2>
                    <div id="health-chart" class="h-72 bg-gray-100 flex items-center justify-center">
                        <div class="grid grid-cols-3 gap-4 w-full max-w-2xl">
                            <div class="text-center">
                                <div class="mx-auto rounded-full w-20 h-20 flex items-center justify-center bg-green-500 text-white text-xl font-bold">75%</div>
                                <p class="mt-2 font-medium">Healthy</p>
                            </div>
                            <div class="text-center">
                                <div class="mx-auto rounded-full w-20 h-20 flex items-center justify-center bg-yellow-500 text-white text-xl font-bold">15%</div>
                                <p class="mt-2 font-medium">Monitor</p>
                            </div>
                            <div class="text-center">
                                <div class="mx-auto rounded-full w-20 h-20 flex items-center justify-center bg-red-500 text-white text-xl font-bold">10%</div>
                                <p class="mt-2 font-medium">Treatment</p>
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Recent Reports -->
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h2 class="text-2xl font-semibold mb-4">Recent Reports</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto border border-gray-200 text-left">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-2 border">Report Type</th>
                                    <th class="px-4 py-2 border">Generated Date</th>
                                    <th class="px-4 py-2 border">Date Range</th>
                                    <th class="px-4 py-2 border">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">Inventory Summary</td>
                                    <td class="px-4 py-2 border">2023-02-01</td>
                                    <td class="px-4 py-2 border">Jan 1 - Jan 31, 2023</td>
                                    <td class="px-4 py-2 border space-x-2">
                                        <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600"><i class="fas fa-download"></i> Download</button>
                                        <button class="bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600"><i class="fas fa-eye"></i> View</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">Health Records</td>
                                    <td class="px-4 py-2 border">2023-01-15</td>
                                    <td class="px-4 py-2 border">Dec 1 - Dec 31, 2022</td>
                                    <td class="px-4 py-2 border space-x-2">
                                        <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600"><i class="fas fa-download"></i> Download</button>
                                        <button class="bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600"><i class="fas fa-eye"></i> View</button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border">Expenses Report</td>
                                    <td class="px-4 py-2 border">2023-01-05</td>
                                    <td class="px-4 py-2 border">Oct 1 - Dec 31, 2022</td>
                                    <td class="px-4 py-2 border space-x-2">
                                        <button class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600"><i class="fas fa-download"></i> Download</button>
                                        <button class="bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600"><i class="fas fa-eye"></i> View</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>
    </div>
    
    <!-- Modal -->
    <div class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50" id="confirm-modal">
        <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-md relative">
            <button class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl close-modal">&times;</button>
            <h2 id="modal-title" class="text-xl font-semibold mb-2">Confirm Action</h2>
            <p id="modal-message" class="text-gray-700">Are you sure you want to perform this action?</p>
            <div class="flex justify-end mt-4 space-x-2">
                <button id="modal-cancel-btn" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Cancel</button>
                <button id="modal-confirm-btn" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Confirm</button>
            </div>
        </div>
    </div>


    <script src = "script.js"></script>
            
    
</body>
</html>
