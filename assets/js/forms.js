// Universal AJAX form handlers for all profile forms
$(document).ready(function() {
    
    // Customer Profile Form
    $('#customerProfileForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: 'model/updateProfile.php',
            type: 'POST',
            data: $(this).serialize(),
            beforeSend: function() {
                $(this).find('button[type="submit"]').prop('disabled', true).text('Saving...');
            },
            success: function(data) {
                alert('Profile updated successfully!');
                window.location.href = 'profile.php?success=1';
            },
            error: function() {
                alert('Error updating profile');
            },
            complete: function() {
                $('#customerProfileForm button[type="submit"]').prop('disabled', false).text('Save Changes');
            }
        });
    });
    
    // Customer Password Form
    $('#customerPasswordForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: 'model/updatePassword.php',
            type: 'POST',
            data: $(this).serialize(),
            beforeSend: function() {
                $(this).find('button[type="submit"]').prop('disabled', true).text('Updating...');
            },
            success: function(data) {
                alert('Password updated successfully!');
                window.location.href = 'profile.php';
            },
            error: function() {
                alert('Error updating password');
            },
            complete: function() {
                $('#customerPasswordForm button[type="submit"]').prop('disabled', false).text('Update Password');
            }
        });
    });
    
    // Employee Profile Form
    $('#employeeProfileForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '../model/updateProfile.php',
            type: 'POST',
            data: $(this).serialize(),
            beforeSend: function() {
                $(this).find('button[type="submit"]').prop('disabled', true).text('Saving...');
            },
            success: function(data) {
                alert('Profile updated successfully!');
                window.location.href = 'profile.php?success=1';
            },
            error: function() {
                alert('Error updating profile');
            },
            complete: function() {
                $('#employeeProfileForm button[type="submit"]').prop('disabled', false).text('Save Changes');
            }
        });
    });
    
    // Employee Password Form
    $('#employeePasswordForm').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: '../model/updatePassword.php',
            type: 'POST',
            data: $(this).serialize(),
            beforeSend: function() {
                $(this).find('button[type="submit"]').prop('disabled', true).text('Updating...');
            },
            success: function(data) {
                alert('Password updated successfully!');
                window.location.href = 'profile.php';
            },
            error: function() {
                alert('Error updating password');
            },
            complete: function() {
                $('#employeePasswordForm button[type="submit"]').prop('disabled', false).text('Update Password');
            }
        });
    });
    
});