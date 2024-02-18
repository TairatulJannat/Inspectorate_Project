<!-- resources/views/backend/blank/pdf.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>DOMPDF Example</title>
    <style>
        /* Content */
        .content {
            margin-top: 150px; /* Adjust as needed to accommodate the header */
            margin-bottom: 150px; /* Adjust as needed to accommodate the footer */
        }

        /* Header */
        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 150px; /* Adjust as needed */
            background-color: #ddd; /* Adjust as needed */
            text-align: center;
            line-height: 150px; /* Adjust as needed */
        }

        /* Footer */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 150px; /* Adjust as needed */
            background-color: #ddd; /* Adjust as needed */
            text-align: center;
            line-height: 150px; /* Adjust as needed */
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        Header Content
    </div>

    <!-- Footer -->
    <div class="footer">
        Page {PAGE_NUM} of {PAGE_COUNT}
    </div>

    <!-- Content -->
    <div class="content">
        <!-- Your content goes here -->
        <p>This is some content on page 1.</p>
    </div>

    <!-- Page break -->
    <div style="page-break-before: always;"></div>

    <!-- Content continued on next page -->
    <div class="content">
        <p>This is some content on page 2.</p>
    </div>

</body>
</html>
