/* Mobile First Responsive Design */
:root {
    --primary: #1e40af;
    --primary-dark: #1e3a8a;
    --secondary: #64748b;
    --success: #10b981;
    --danger: #ef4444;
    --warning: #f59e0b;
    --light: #f8fafc;
    --dark: #1e293b;
}

* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f1f5f9;
    color: #334155;
}

/* Navigation */
.navbar {
    background: var(--primary);
    color: white;
    padding: 1rem;
    position: fixed;
    width: 100%;
    top: 0;
    z-index: 1000;
}

.nav-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1200px;
    margin: 0 auto;
}

.mobile-menu-btn {
    display: none;
    background: none;
    border: none;
    color: white;
    font-size: 1.5rem;
    cursor: pointer;
}

/* Sidebar for Desktop */
.sidebar {
    width: 250px;
    background: white;
    position: fixed;
    top: 60px;
    left: 0;
    height: calc(100vh - 60px);
    box-shadow: 2px 0 5px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.sidebar-menu {
    list-style: none;
    padding: 1rem 0;
}

.sidebar-menu li a {
    display: flex;
    align-items: center;
    padding: 0.75rem 1.5rem;
    color: var(--dark);
    text-decoration: none;
    transition: all 0.3s;
}

.sidebar-menu li a:hover {
    background: #e2e8f0;
    color: var(--primary);
}

/* Main Content */
.main-content {
    margin-left: 250px;
    margin-top: 60px;
    padding: 1rem;
    min-height: calc(100vh - 60px);
}

/* Cards */
.card {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    padding: 1.5rem;
    margin-bottom: 1rem;
}

/* Tables */
.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th,
.data-table td {
    padding: 0.75rem;
    text-align: left;
    border-bottom: 1px solid #e2e8f0;
}

.data-table th {
    background: #f8fafc;
    font-weight: 600;
}

/* Forms */
.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.form-control {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #d1d5db;
    border-radius: 4px;
    font-size: 1rem;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 4px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s;
}

.btn-primary {
    background: var(--primary);
    color: white;
}

.btn-primary:hover {
    background: var(--primary-dark);
}

/* Mobile Styles */
@media (max-width: 768px) {
    .mobile-menu-btn {
        display: block;
    }
    
    .sidebar {
        transform: translateX(-100%);
    }
    
    .sidebar.active {
        transform: translateX(0);
    }
    
    .main-content {
        margin-left: 0;
    }
    
    .data-table {
        min-width: 600px;
    }
}

@media (max-width: 480px) {
    .main-content {
        padding: 0.5rem;
    }
    
    .card {
        padding: 1rem;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        font-size: 0.8rem;
    }
}