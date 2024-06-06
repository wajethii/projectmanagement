<script>
  document.addEventListener('DOMContentLoaded', function() {
    var path = window.location.pathname;
    var page = path.split("/").pop();
    var navLinks = document.querySelectorAll('.navbar-nav .nav-link');

    navLinks.forEach(function(link) {
      if (link.getAttribute('href') === page) {
        link.classList.add('active');
      }
    });
  });
</script>

<script>
                document.getElementById('selectAll').addEventListener('change', function () {
                    var checkboxes = document.querySelectorAll('input[name="user_ids[]"]');
                    for (var checkbox of checkboxes) {
                        checkbox.checked = this.checked;
                    }
                    toggleDeleteSelectedBtn();
                });

                document.querySelectorAll('input[name="user_ids[]"]').forEach(function (checkbox) {
                    checkbox.addEventListener('change', function () {
                        toggleDeleteSelectedBtn();
                    });
                });

                function toggleDeleteSelectedBtn() {
                    var selectedCheckboxes = document.querySelectorAll('input[name="user_ids[]"]:checked').length;
                    var deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
                    if (selectedCheckboxes >= 2) {
                        deleteSelectedBtn.style.display = 'inline-block';
                    } else {
                        deleteSelectedBtn.style.display = 'none';
                    }
                }
            </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Edit Modal for Technicians
        var editTechModal = document.getElementById('EditTechModal');
        if (editTechModal) {
            editTechModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var techId = button.getAttribute('data-id');
                var name = button.getAttribute('data-name');
                var department = button.getAttribute('data-department');
                var overtimeHours = button.getAttribute('data-overtime');
                var wages = button.getAttribute('data-wages');
                var contractLength = button.getAttribute('data-contract');
                var status = button.getAttribute('data-status');

                var modalTechId = editTechModal.querySelector('input[name="tech_id"]');
                var modalName = editTechModal.querySelector('input[name="full_name"]');
                var modalDepartment = editTechModal.querySelector('select[name="department"]');
                var modalOvertimeHours = editTechModal.querySelector('input[name="overtime_hours"]');
                var modalWages = editTechModal.querySelector('input[name="wages"]');
                var modalContractLength = editTechModal.querySelector('input[name="contract_length"]');
                var modalStatus = editTechModal.querySelector('select[name="status"]');

                if (!modalTechId) {
                    modalTechId = document.createElement('input');
                    modalTechId.type = 'hidden';
                    modalTechId.name = 'tech_id';
                    editTechModal.querySelector('form').appendChild(modalTechId);
                }

                modalTechId.value = techId;
                modalName.value = name;
                modalDepartment.value = department;
                modalOvertimeHours.value = overtimeHours;
                modalWages.value = wages;
                modalContractLength.value = contractLength;
                modalStatus.value = status;
            });
        }

        // Edit Modal for Users
        var editUserModal = document.getElementById('EditUserModal');
        if (editUserModal) {
            editUserModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var userId = button.getAttribute('data-id');
                var username = button.getAttribute('data-username');
                var email = button.getAttribute('data-email');
                var password = button.getAttribute('data-password');

                var modalTitle = editUserModal.querySelector('.modal-title');
                var modalUserId = editUserModal.querySelector('#editUserId');
                var modalUsername = editUserModal.querySelector('#editUsername');
                var modalEmail = editUserModal.querySelector('#editEmail');
                var modalPassword = editUserModal.querySelector('#editPassword');

                modalTitle.textContent = 'Edit ' + username;
                modalUserId.value = userId;
                modalUsername.value = username;
                modalEmail.value = email;
                modalPassword.value = password;
            });
        }

        // Edit Modal for Clients
        var editClientModal = document.getElementById('EditClientModal');
        if (editClientModal) {
            editClientModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var clientId = button.getAttribute('data-id');
                var name = button.getAttribute('data-name');
                var contactInfo = button.getAttribute('data-contact');
                var servicesRequired = button.getAttribute('data-services');
                var completionDate = button.getAttribute('data-completion');
                var amountCharged = button.getAttribute('data-amount');
                var status = button.getAttribute('data-status');

                var modalClientId = editClientModal.querySelector('#editClientId');
                var modalName = editClientModal.querySelector('#editName');
                var modalContactInfo = editClientModal.querySelector('#editContactInfo');
                var modalServicesRequired = editClientModal.querySelector('#editServicesRequired');
                var modalCompletionDate = editClientModal.querySelector('#editProjectedCompletionDate');
                var modalAmountCharged = editClientModal.querySelector('#editAmountCharged');
                var modalStatusComplete = editClientModal.querySelector('#editStatusComplete');
                var modalStatusInProgress = editClientModal.querySelector('#editStatusInProgress');

                modalClientId.value = clientId;
                modalName.value = name;
                modalContactInfo.value = contactInfo;
                modalServicesRequired.value = servicesRequired;
                modalCompletionDate.value = completionDate;
                modalAmountCharged.value = amountCharged;

                if (status === 'Complete') {
                    modalStatusComplete.checked = true;
                } else {
                    modalStatusInProgress.checked = true;
                }
            });
        }

        // Initialize DataTables
        $('#clientsTable').DataTable({
            "order": [[1, "asc"]]
        });

        $('#techniciansTable').DataTable({
            "order": [[1, "asc"]]  // Default sort by the second column (Full Name) in ascending order
        });
    });
</script>