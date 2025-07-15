<?php
require_once 'functions.php';

// If user is already logged in, redirect to appropriate dashboard
if(is_logged_in()) {
    header('Location: ' . (is_student() ? 'student_dashboard.php' : 'teacher_dashboard.php'));
    exit;
}

include 'header.php';
?>

<div class="hero-section">
    <h1>CZMG - College Project Management System</h1>
    <p class="lead">A comprehensive platform for managing student projects and academic submissions</p>
</div>

<div class="features-section">
    <div class="container">
        <div class="row">
            <div class="feature-card">
                <h3>For Students</h3>
                <ul>
                    <li>Submit projects online</li>
                    <li>Track submission status</li>
                    <li>View feedback and grades</li>
                    <li>Manage project files</li>
                </ul>
                <a href="login.php" class="btn btn-primary">Student Login</a>
            </div>
            
            <div class="feature-card">
                <h3>For Teachers</h3>
                <ul>
                    <li>Review student submissions</li>
                    <li>Provide feedback and grades</li>
                    <li>Search and filter projects</li>
                    <li>Track student progress</li>
                </ul>
                <a href="login.php" class="btn btn-secondary">Teacher Login</a>
            </div>
        </div>
    </div>
</div>

<div class="info-section">
    <div class="container">
        <h2>Getting Started</h2>
        <div class="steps">
            <div class="step">
                <div class="step-number">1</div>
                <h4>Login</h4>
                <p>Use your credentials to access the system</p>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <h4>Navigate</h4>
                <p>Access your personalized dashboard</p>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <h4>Manage</h4>
                <p>Submit projects or review submissions</p>
            </div>
        </div>
    </div>
</div>

<style>
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    text-align: center;
    padding: 80px 20px;
    margin-bottom: 40px;
}

.hero-section h1 {
    font-size: 3em;
    margin-bottom: 20px;
    font-weight: 300;
}

.lead {
    font-size: 1.3em;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
}

.features-section {
    padding: 60px 20px;
    background-color: #f8f9fa;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
}

.row {
    display: flex;
    gap: 40px;
    justify-content: center;
    flex-wrap: wrap;
}

.feature-card {
    background: white;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    flex: 1;
    min-width: 300px;
    max-width: 400px;
    text-align: center;
}

.feature-card h3 {
    color: #333;
    margin-bottom: 20px;
    font-size: 1.8em;
}

.feature-card ul {
    list-style: none;
    padding: 0;
    margin: 20px 0 30px 0;
}

.feature-card li {
    padding: 8px 0;
    color: #666;
    border-bottom: 1px solid #eee;
}

.feature-card li:last-child {
    border-bottom: none;
}

.btn {
    display: inline-block;
    padding: 12px 30px;
    text-decoration: none;
    border-radius: 5px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: #007bff;
    color: white;
}

.btn-primary:hover {
    background-color: #0056b3;
    transform: translateY(-2px);
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background-color: #545b62;
    transform: translateY(-2px);
}

.info-section {
    padding: 60px 20px;
}

.info-section h2 {
    text-align: center;
    margin-bottom: 40px;
    color: #333;
    font-size: 2.5em;
}

.steps {
    display: flex;
    justify-content: center;
    gap: 40px;
    flex-wrap: wrap;
}

.step {
    text-align: center;
    max-width: 250px;
}

.step-number {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5em;
    font-weight: bold;
    margin: 0 auto 20px auto;
}

.step h4 {
    color: #333;
    margin-bottom: 10px;
    font-size: 1.3em;
}

.step p {
    color: #666;
    line-height: 1.6;
}

@media (max-width: 768px) {
    .hero-section h1 {
        font-size: 2em;
    }
    
    .row {
        flex-direction: column;
        align-items: center;
    }
    
    .steps {
        flex-direction: column;
        align-items: center;
    }
}
</style>

<?php include 'footer.php'; ?>