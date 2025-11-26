<?php
Auth::requireLogin();

$user = Auth::getCurrentUser();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help & Support - User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .navbar-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .help-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .help-card:hover {
            transform: translateY(-2px);
        }
        .faq-item {
            border-bottom: 1px solid #e9ecef;
            padding: 1.5rem 0;
        }
        .faq-item:last-child {
            border-bottom: none;
        }
        .faq-question {
            font-weight: 600;
            color: #495057;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .faq-answer {
            color: #6c757d;
            margin-top: 0.5rem;
            display: none;
        }
        .contact-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
        }
        .btn-help {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            border: none;
            border-radius: 25px;
            padding: 12px 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-help:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }
        .support-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }
        .quick-link {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            text-decoration: none;
            color: #495057;
            display: block;
            transition: all 0.3s ease;
        }
        .quick-link:hover {
            background: #667eea;
            color: white;
            text-decoration: none;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand text-white fw-bold" href="/dashboard">
                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
            </a>
            <div class="d-flex align-items-center">
                <span class="badge bg-light text-dark me-3">
                    <i class="fas fa-user me-1"></i><?php echo htmlspecialchars($user['name']); ?>
                </span>
                <a href="/logout" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="text-center mb-5">
            <i class="fas fa-question-circle support-icon text-primary"></i>
            <h1 class="fw-bold mb-3">Help & Support Center</h1>
            <p class="lead text-muted">Find answers to your questions and get the help you need</p>
        </div>

        <div class="row g-4">
            <!-- Quick Links -->
            <div class="col-lg-4">
                <div class="help-card p-4">
                    <h4 class="fw-bold mb-4">
                        <i class="fas fa-link me-2 text-primary"></i>Quick Links
                    </h4>
                    <div class="d-grid gap-3">
                        <a href="#getting-started" class="quick-link">
                            <i class="fas fa-play-circle me-2"></i>Getting Started Guide
                        </a>
                        <a href="#account" class="quick-link">
                            <i class="fas fa-user me-2"></i>Account Management
                        </a>
                        <a href="#security" class="quick-link">
                            <i class="fas fa-shield-alt me-2"></i>Security & Privacy
                        </a>
                        <a href="#troubleshooting" class="quick-link">
                            <i class="fas fa-tools me-2"></i>Troubleshooting
                        </a>
                        <a href="#contact" class="quick-link">
                            <i class="fas fa-envelope me-2"></i>Contact Support
                        </a>
                    </div>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="col-lg-8">
                <div class="help-card p-4">
                    <h4 class="fw-bold mb-4">
                        <i class="fas fa-question-circle me-2 text-success"></i>Frequently Asked Questions
                    </h4>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFAQ(this)">
                            <span>How do I update my profile information?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            To update your profile information, go to your dashboard and click on "My Profile" or "Edit Profile". You can update your name, email address, and password from there.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFAQ(this)">
                            <span>How do I change my password?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            You can change your password from the profile page. Leave the password field blank if you don't want to change it. Make sure your new password is at least 6 characters long.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFAQ(this)">
                            <span>What should I do if I forget my password?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            If you forget your password, contact your system administrator. Password reset functionality will be available in a future update.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFAQ(this)">
                            <span>How do I access the code editor?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            The code editor is available from the "Available Features" section on your dashboard. Click on "Code Editor" to access it.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFAQ(this)">
                            <span>Is my data secure?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            Yes, we take security seriously. All passwords are hashed using bcrypt, and we implement various security measures to protect your data. For administrators, additional security settings are available.
                        </div>
                    </div>

                    <div class="faq-item">
                        <div class="faq-question" onclick="toggleFAQ(this)">
                            <span>How do I contact support?</span>
                            <i class="fas fa-chevron-down"></i>
                        </div>
                        <div class="faq-answer">
                            You can contact support using the contact form below or by emailing support@example.com. For urgent issues, please call our support hotline.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Support -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="contact-card" id="contact">
                    <i class="fas fa-headset support-icon"></i>
                    <h3 class="fw-bold mb-3">Still Need Help?</h3>
                    <p class="mb-4">Our support team is here to help you with any questions or issues you may have.</p>

                    <div class="row g-4 justify-content-center">
                        <div class="col-md-4">
                            <div class="bg-white bg-opacity-10 rounded p-3">
                                <i class="fas fa-envelope fa-2x mb-2"></i>
                                <h5>Email Support</h5>
                                <p class="mb-0">support@example.com</p>
                                <small>Response within 24 hours</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-white bg-opacity-10 rounded p-3">
                                <i class="fas fa-phone fa-2x mb-2"></i>
                                <h5>Phone Support</h5>
                                <p class="mb-0">1-800-123-4567</p>
                                <small>Mon-Fri, 9AM-6PM</small>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-white bg-opacity-10 rounded p-3">
                                <i class="fas fa-comments fa-2x mb-2"></i>
                                <h5>Live Chat</h5>
                                <p class="mb-0">Available 24/7</p>
                                <small>Instant response</small>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <button class="btn btn-help btn-lg" onclick="showContactForm()">
                            <i class="fas fa-envelope me-2"></i>Send us a Message
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form Modal -->
        <div class="modal fade" id="contactModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-envelope me-2"></i>Contact Support
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form id="contactForm">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="contactName" class="form-label">Your Name</label>
                                    <input type="text" class="form-control" id="contactName" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contactEmail" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="contactEmail" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="contactSubject" class="form-label">Subject</label>
                                <select class="form-select" id="contactSubject" required>
                                    <option value="">Choose a subject...</option>
                                    <option value="technical">Technical Issue</option>
                                    <option value="account">Account Problem</option>
                                    <option value="feature">Feature Request</option>
                                    <option value="billing">Billing Question</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="contactMessage" class="form-label">Message</label>
                                <textarea class="form-control" id="contactMessage" rows="5" placeholder="Describe your issue or question..." required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-help">
                                <i class="fas fa-paper-plane me-2"></i>Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleFAQ(element) {
            const answer = element.nextElementSibling;
            const icon = element.querySelector('i');

            if (answer.style.display === 'block') {
                answer.style.display = 'none';
                icon.className = 'fas fa-chevron-down';
            } else {
                answer.style.display = 'block';
                icon.className = 'fas fa-chevron-up';
            }
        }

        function showContactForm() {
            const modal = new bootstrap.Modal(document.getElementById('contactModal'));
            modal.show();
        }

        document.getElementById('contactForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Show success message
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
            submitBtn.disabled = true;

            // Simulate sending (replace with actual AJAX call)
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;

                // Close modal and show success message
                const modal = bootstrap.Modal.getInstance(document.getElementById('contactModal'));
                modal.hide();

                // Show toast notification
                showToast('Your message has been sent successfully! We\'ll get back to you soon.', 'success');
            }, 2000);
        });

        function showToast(message, type) {
            const toastContainer = document.getElementById('toastContainer') || createToastContainer();

            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0`;
            toast.setAttribute('role', 'alert');
            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;

            toastContainer.appendChild(toast);
            const bsToast = new bootstrap.Toast(toast);
            bsToast.show();

            toast.addEventListener('hidden.bs.toast', () => {
                toast.remove();
            });
        }

        function createToastContainer() {
            const container = document.createElement('div');
            container.id = 'toastContainer';
            container.className = 'toast-container position-fixed top-0 end-0 p-3';
            container.style.zIndex = '9999';
            document.body.appendChild(container);
            return container;
        }
    </script>
</body>
</html>