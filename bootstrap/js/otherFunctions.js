function generateBatchID() {
    // Get the prefix from the input
    const prefix = document.getElementById("txtBatchPrefix").value;

    // Get the selected dates
    const startDate = new Date(document.getElementById("txtStartDate").value);
    const endDate = new Date(document.getElementById("txtEndDate").value);

    if (startDate && endDate) {
        const startMonthYear = startDate.toLocaleString('default', { month: 'short', year: 'numeric' });
        const endMonthYear = endDate.toLocaleString('default', { month: 'short', year: 'numeric' });

        // Combine the month and year with a hyphen
        const formattedStartDate = startMonthYear.replace(' ', '-');
        const formattedEndDate = endMonthYear.replace(' ', '-');

        const batchID = prefix + formattedStartDate + "-to-" + formattedEndDate;

        document.getElementById("txtGeneratedBatchID").value = batchID;
        alert("Generated Batch Name: \n" + batchID)
    } else {
        alert("Please select both start and end dates.");
    }
}