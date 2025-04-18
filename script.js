
        // Sample data for demonstration
        let animalsData = [
            { id: 'A001', type: 'Cattle', breed: 'Holstein', dob: '2020-04-15', gender: 'Female', weight: 650, notes: 'Dairy cow, good milk producer' },
            { id: 'A002', type: 'Sheep', breed: 'Merino', dob: '2021-02-10', gender: 'Male', weight: 75, notes: 'Wool producer' },
            { id: 'A003', type: 'Pig', breed: 'Yorkshire', dob: '2021-07-22', gender: 'Female', weight: 120, notes: 'Breeding sow' }
        ];

        let healthRecords = [
            { animalId: 'A001', date: '2023-01-15', type: 'Vaccination', description: 'Annual vaccination against common diseases', treatment: 'Vaccine XYZ', cost: 45, nextFollowup: '2024-01-15' },
            { animalId: 'A002', date: '2023-02-10', type: 'Treatment', description: 'Treated for minor wound on left leg', treatment: 'Antibiotics', cost: 25, nextFollowup: '2023-02-17' },
            { animalId: 'A003', date: '2023-02-20', type: 'Checkup', description: 'Routine health checkup - all parameters normal', treatment: 'N/A', cost: 30, nextFollowup: '2023-08-20' }
        ];

        let feedingSchedules = [
            { group: 'Cattle', time: 'Morning', feedType: 'Hay Mix', quantity: 5.00, notes: 'Mix with vitamin supplement' },
            { group: 'Cattle', time: 'Evening', feedType: 'Grain Mix', quantity: 3.50, notes: 'Add mineral supplements' },
            { group: 'Pigs', time: 'Morning', feedType: 'Pig Feed', quantity: 2.00, notes: 'Ensure clean water available' },
            { group: 'Pigs', time: 'Evening', feedType: 'Pig Feed', quantity: 1.80, notes: 'Mix with vegetable scraps' },
            { group: 'Sheep', time: 'Morning', feedType: 'Pasture', quantity: 1.50, notes: 'Rotational grazing in field 3' }
        ];

        // Update dashboard stats
        document.getElementById('total-animals').textContent = animalsData.length;
        document.getElementById('health-alerts').textContent = '2';
        document.getElementById('feeding-today').textContent = '5';
        document.getElementById('monthly-costs').textContent = '$325';

        // Navigation functionality
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('click', () => {
                // Hide all pages
                document.querySelectorAll('.page').forEach(page => {
                    page.classList.remove('active');
                });
                
                // Remove active class from all menu items
                document.querySelectorAll('.menu-item').forEach(menuItem => {
                    menuItem.classList.remove('active');
                });
                
                // Add active class to clicked menu item
                item.classList.add('active');
                
                // Show corresponding page
                const pageId = item.getAttribute('data-page');
                document.getElementById(pageId).classList.add('active');
            });
        });

        // Form submissions
        document.getElementById('add-animal-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const newAnimal = {
                id: document.getElementById('animal-id').value,
                type: document.getElementById('animal-type').value,
                breed: document.getElementById('animal-breed').value,
                dob: document.getElementById('animal-dob').value,
                gender: document.getElementById('animal-gender').value,
                weight: parseFloat(document.getElementById('animal-weight').value),
                notes: document.getElementById('animal-notes').value
            };
            
            // Add to array (in real app, would send to server)
            animalsData.push(newAnimal);
            
            // Update table
            updateAnimalTable();
            
            // Reset form
            this.reset();
            
            // Show success message
            showAlert('animal-success-alert');
            
            // Update dashboard count
            document.getElementById('total-animals').textContent = animalsData.length;
        });

        document.getElementById('add-health-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const newRecord = {
                animalId: document.getElementById('health-animal-id').value,
                date: document.getElementById('health-date').value,
                type: document.getElementById('health-type').value,
                description: document.getElementById('health-description').value,
                treatment: document.getElementById('health-treatment').value,
                cost: parseFloat(document.getElementById('health-cost').value || 0),
                nextFollowup: document.getElementById('health-next-followup').value
            };
            
            // Add to array
            healthRecords.push(newRecord);
            
            // Update table
            updateHealthTable();
            
            // Reset form
            this.reset();
            
            // Show success message
            showAlert('health-success-alert');
        });

        document.getElementById('add-feeding-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form values
            const newSchedule = {
                group: document.getElementById('feeding-group').value,
                time: document.getElementById('feeding-time').value,
                feedType: document.getElementById('feeding-feed-type').value,
                quantity: parseFloat(document.getElementById('feeding-quantity').value),
                notes: document.getElementById('feeding-notes').value
            };
            
            // Add to array
            feedingSchedules.push(newSchedule);
            
            // Update table
            updateFeedingTable();
            
            // Reset form
            this.reset();
            
            // Show success message
            showAlert('feeding-success-alert');
        });

        document.getElementById('generate-report-form').addEventListener('submit', function(e) {
            e.preventDefault();
            showConfirmModal('Generate Report', 'Report will be generated for the selected period. This might take a moment.', () => {
                alert('Report generated successfully. In a real application, this would create a PDF report from the data.');
            });
        });

        // Functions to update tables
        function updateAnimalTable() {
            const tableBody = document.querySelector('#animals-table tbody');
            tableBody.innerHTML = '';
            
            animalsData.forEach((animal, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td class="p-2 border">${animal.id}</td>
                    <td class="p-2 border">${animal.type}</td>
                    <td class="p-2 border">${animal.breed}</td>
                    <td class="p-2 border">${animal.dob}</td>
                    <td class="p-2 border">${animal.gender}</td>
                    <td class="p-2 border">${animal.weight}</td>
                    <td class="p-2 border space-x-2">
                        <button class="text-blue-500 hover:underline edit-btn" data-id="${animal.id}"><i class="fas fa-edit"></i></button>
                        <button class="text-red-500 hover:underline delete-btn" data-id="${animal.id}" data-index="${index}"><i class="fas fa-trash"></i></button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
            
            // Attach event listeners to new buttons
            attachActionButtons();
        }

        function updateHealthTable() {
            const tableBody = document.querySelector('#health-table tbody');
            tableBody.innerHTML = '';
            
            healthRecords.forEach((record, index) => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                row.innerHTML = `
                    <td class="px-4 py-2 border">${record.animalId}</td>
                    <td class="px-4 py-2 border">${record.date}</td>
                    <td class="px-4 py-2 border">${record.type}</td>
                    <td class="px-4 py-2 border">${record.description}</td>
                    <td class="px-4 py-2 border">${record.treatment}</td>
                    <td class="px-4 py-2 border">$${record.cost.toFixed(2)}</td>
                    <td class="px-4 py-2 border">${record.nextFollowup || 'N/A'}</td>
                    <td class="px-4 py-2 border space-x-2">
                        <button class="text-blue-600 hover:text-blue-800 edit-btn" data-index="${index}"><i class="fas fa-edit"></i></button>
                        <button class="text-red-600 hover:text-red-800 delete-btn" data-index="${index}"><i class="fas fa-trash"></i></button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
            
            // Attach event listeners to new buttons
            attachActionButtons();
        }

        function updateFeedingTable() {
            const tableBody = document.querySelector('#feeding-table tbody');
            tableBody.innerHTML = '';
            
            feedingSchedules.forEach((schedule, index) => {
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                row.innerHTML = `
                    <td class="px-4 py-2 border">${schedule.group}</td>
                    <td class="px-4 py-2 border">${schedule.time}</td>
                    <td class="px-4 py-2 border">${schedule.feedType}</td>
                    <td class="px-4 py-2 border">${schedule.quantity.toFixed(2)}</td>
                    <td class="px-4 py-2 border">${schedule.notes || 'N/A'}</td>
                    <td class="px-4 py-2 border space-x-2">
                        <button class="text-blue-600 hover:text-blue-800 edit-btn" data-index="${index}"><i class="fas fa-edit"></i></button>
                        <button class="text-red-600 hover:text-red-800 delete-btn" data-index="${index}"><i class="fas fa-trash"></i></button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
            
            // Attach event listeners to new buttons
            attachActionButtons();
        }

        // Attach event listeners to action buttons
        function attachActionButtons() {
            // Handle edit and delete buttons for animals
            document.querySelectorAll('#animals-table .edit-btn, #animals-table .delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const animalId = this.getAttribute('data-id');
                    const index = this.getAttribute('data-index');
                    
                    if (this.classList.contains('edit-btn')) {
                        alert(`Edit functionality for animal ${animalId} would be implemented here`);
                    } else if (this.classList.contains('delete-btn')) {
                        showConfirmModal('Delete Animal', `Are you sure you want to delete animal ${animalId}? This action cannot be undone.`, () => {
                            animalsData.splice(index, 1);
                            updateAnimalTable();
                            document.getElementById('total-animals').textContent = animalsData.length;
                        });
                    }
                });
            });
            
            // Handle edit and delete buttons for health records
            document.querySelectorAll('#health-table .edit-btn, #health-table .delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const index = this.getAttribute('data-index');
                    
                    if (this.classList.contains('edit-btn')) {
                        alert(`Edit functionality for health record at index ${index} would be implemented here`);
                    } else if (this.classList.contains('delete-btn')) {
                        showConfirmModal('Delete Health Record', 'Are you sure you want to delete this health record? This action cannot be undone.', () => {
                            healthRecords.splice(index, 1);
                            updateHealthTable();
                        });
                    }
                });
            });
            
            // Handle edit and delete buttons for feeding schedules
            document.querySelectorAll('#feeding-table .edit-btn, #feeding-table .delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const index = this.getAttribute('data-index');
                    
                    if (this.classList.contains('edit-btn')) {
                        alert(`Edit functionality for feeding schedule at index ${index} would be implemented here`);
                    } else if (this.classList.contains('delete-btn')) {
                        showConfirmModal('Delete Feeding Schedule', 'Are you sure you want to delete this feeding schedule? This action cannot be undone.', () => {
                            feedingSchedules.splice(index, 1);
                            updateFeedingTable();
                        });
                    }
                });
            });
        }

        // Modal functionality
        const modal = document.getElementById('confirm-modal');
        const closeModal = document.querySelector('.close-modal');
        const cancelBtn = document.getElementById('modal-cancel-btn');
        let confirmCallback = null;

        function showConfirmModal(title, message, callback) {
            document.getElementById('modal-title').textContent = title;
            document.getElementById('modal-message').textContent = message;
            confirmCallback = callback;
            modal.style.display = 'flex';
        }

        if (closeModal) {
            closeModal.addEventListener('click', () => {
                modal.style.display = 'none';
            });
        }

        cancelBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        document.getElementById('modal-confirm-btn').addEventListener('click', () => {
            if (confirmCallback) confirmCallback();
            modal.style.display = 'none';
        });

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Alert functionality
        function showAlert(alertId) {
            const alert = document.getElementById(alertId);
            alert.classList.remove('hidden');
            setTimeout(() => {
                alert.classList.add('hidden');
            }, 3000);
        }

        // Initialize the application
        document.addEventListener('DOMContentLoaded', function() {
            // Make sure initial values are set
            updateAnimalTable();
            updateHealthTable();
            updateFeedingTable();

            // Attach event listeners to action buttons
            attachActionButtons();
        });
    