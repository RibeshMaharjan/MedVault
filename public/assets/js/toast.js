// Toast notification functionality
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide toasts after 5 seconds
    const toasts = document.querySelectorAll('.toast.show');
    toasts.forEach(toast => {
        setTimeout(() => {
            toast.classList.remove('show');
        }, 5000);
    });

    // Make toasts dismissible
    document.querySelectorAll('.toast .btn-close').forEach(btn => {
        btn.addEventListener('click', function() {
            this.closest('.toast').classList.remove('show');
        });
    });
}); 