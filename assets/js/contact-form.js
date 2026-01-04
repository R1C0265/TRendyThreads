document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.php-email-form');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const loading = form.querySelector('.loading');
            const errorMessage = form.querySelector('.error-message');
            const sentMessage = form.querySelector('.sent-message');
            const submitBtn = form.querySelector('button[type="submit"]');
            
            // Reset states
            loading.style.display = 'block';
            errorMessage.style.display = 'none';
            sentMessage.style.display = 'none';
            submitBtn.disabled = true;
            
            // Prepare form data
            const formData = new FormData(form);
            
            // Send AJAX request
            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                loading.style.display = 'none';
                submitBtn.disabled = false;
                
                if (data.status === 'success') {
                    sentMessage.style.display = 'block';
                    form.reset();
                } else {
                    errorMessage.textContent = data.message || 'An error occurred';
                    errorMessage.style.display = 'block';
                }
            })
            .catch(error => {
                loading.style.display = 'none';
                submitBtn.disabled = false;
                errorMessage.textContent = 'Network error occurred';
                errorMessage.style.display = 'block';
            });
        });
    }
});