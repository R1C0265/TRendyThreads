<?php
require_once 'partials/header.php';

// Fetch all users
$users = $db->query("SELECT * FROM users ORDER BY u_id DESC")->fetchAll();
?>

<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <div class="card my-4">
        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
          <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
            <div class="d-flex justify-content-between align-items-center">
              <h6 class="text-white text-capitalize ps-3">Users Management</h6>
              <button class="btn btn-light btn-sm me-3" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="material-icons">add</i> Add User
              </button>
            </div>
          </div>
        </div>
        <div class="card-body px-0 pb-2">
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
              <thead>
                <tr>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">User</th>
                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Contact</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                  <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Joined</th>
                  <th class="text-secondary opacity-7">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                  <td>
                    <div class="d-flex px-2 py-1">
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm"><?php echo htmlspecialchars($user['u_name']); ?></h6>
                        <p class="text-xs text-secondary mb-0"><?php echo htmlspecialchars($user['u_email']); ?></p>
                      </div>
                    </div>
                  </td>
                  <td>
                    <p class="text-xs font-weight-bold mb-0"><?php echo htmlspecialchars($user['u_phone'] ?? 'N/A'); ?></p>
                    <p class="text-xs text-secondary mb-0"><?php echo htmlspecialchars($user['u_address'] ?? 'N/A'); ?></p>
                  </td>
                  <td class="align-middle text-center text-sm">
                    <span class="badge badge-sm bg-gradient-<?php echo $user['u_type'] == '1' ? 'danger' : ($user['u_type'] == '2' ? 'warning' : 'success'); ?>">
                      <?php 
                        echo $user['u_type'] == '1' ? 'Admin' : ($user['u_type'] == '2' ? 'Employee' : 'Customer');
                      ?>
                    </span>
                  </td>
                  <td class="align-middle text-center">
                    <span class="text-secondary text-xs font-weight-bold"><?php echo date('M d, Y', strtotime($user['created_at'] ?? 'now')); ?></span>
                  </td>
                  <td class="align-middle">
                    <button class="btn btn-link text-dark px-3 mb-0" onclick="editUser(<?php echo $user['u_id']; ?>)">
                      <i class="material-icons text-sm me-2">edit</i>Edit
                    </button>
                    <button class="btn btn-link text-danger text-gradient px-3 mb-0" onclick="deleteUser(<?php echo $user['u_id']; ?>)">
                      <i class="material-icons text-sm me-2">delete</i>Delete
                    </button>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add New User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="addUserForm">
        <div class="modal-body">
          <div class="input-group input-group-outline mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="u_name" class="form-control" required>
          </div>
          <div class="input-group input-group-outline mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="u_email" class="form-control" required>
          </div>
          <div class="input-group input-group-outline mb-3">
            <label class="form-label">Phone</label>
            <input type="tel" name="u_phone" class="form-control">
          </div>
          <div class="input-group input-group-outline mb-3">
            <label class="form-label">Address</label>
            <textarea name="u_address" class="form-control" rows="2"></textarea>
          </div>
          <div class="input-group input-group-outline mb-3">
            <select name="u_type" class="form-control" required>
              <option value="">Select User Type</option>
              <option value="1">Admin</option>
              <option value="2">Employee</option>
              <option value="3">Customer</option>
            </select>
          </div>
          <div class="input-group input-group-outline mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="u_password" class="form-control" minlength="6" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Add User</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <form id="editUserForm">
        <input type="hidden" name="u_id" id="edit_u_id">
        <div class="modal-body">
          <div class="input-group input-group-outline mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="u_name" id="edit_u_name" class="form-control" required>
          </div>
          <div class="input-group input-group-outline mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="u_email" id="edit_u_email" class="form-control" required>
          </div>
          <div class="input-group input-group-outline mb-3">
            <label class="form-label">Phone</label>
            <input type="tel" name="u_phone" id="edit_u_phone" class="form-control">
          </div>
          <div class="input-group input-group-outline mb-3">
            <label class="form-label">Address</label>
            <textarea name="u_address" id="edit_u_address" class="form-control" rows="2"></textarea>
          </div>
          <div class="input-group input-group-outline mb-3">
            <select name="u_type" id="edit_u_type" class="form-control" required>
              <option value="1">Admin</option>
              <option value="2">Employee</option>
              <option value="3">Customer</option>
            </select>
          </div>
          <div class="input-group input-group-outline mb-3">
            <label class="form-label">New Password (leave blank to keep current)</label>
            <input type="password" name="u_password" class="form-control" minlength="6">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Update User</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// Add User
$('#addUserForm').on('submit', function(e) {
  e.preventDefault();
  $.ajax({
    url: '../model/addUser.php',
    type: 'POST',
    data: $(this).serialize(),
    success: function(response) {
      if (response == '1') {
        alert('User added successfully!');
        location.reload();
      } else if (response == '3') {
        alert('Email already exists!');
      } else {
        alert('Error adding user.');
      }
    }
  });
});

// Edit User
function editUser(userId) {
  $.ajax({
    url: '../model/getUser.php',
    type: 'POST',
    data: {u_id: userId},
    dataType: 'json',
    success: function(user) {
      $('#edit_u_id').val(user.u_id);
      $('#edit_u_name').val(user.u_name);
      $('#edit_u_email').val(user.u_email);
      $('#edit_u_phone').val(user.u_phone);
      $('#edit_u_address').val(user.u_address);
      $('#edit_u_type').val(user.u_type);
      $('#editUserModal').modal('show');
    }
  });
}

$('#editUserForm').on('submit', function(e) {
  e.preventDefault();
  $.ajax({
    url: '../model/updateUser.php',
    type: 'POST',
    data: $(this).serialize(),
    success: function(response) {
      if (response == '1') {
        alert('User updated successfully!');
        location.reload();
      } else {
        alert('Error updating user.');
      }
    }
  });
});

// Delete User
function deleteUser(userId) {
  if (confirm('Are you sure you want to delete this user?')) {
    $.ajax({
      url: '../model/deluser.php',
      type: 'POST',
      data: {u_id: userId},
      success: function(response) {
        if (response == '1') {
          alert('User deleted successfully!');
          location.reload();
        } else {
          alert('Error deleting user.');
        }
      }
    });
  }
}
</script>

<?php require_once 'partials/footer.php'; ?>