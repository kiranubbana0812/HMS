$(document).ready(function () {
    $('.view-btn').on('click', function () {
        const billing = $(this).data('billing');
        console.log(":: DATA ::"+JSON.stringify(billing));
		// Patient details
        if (billing.patient) {
            $('#modal-name').text(billing.patient.user?.name || billing.patient_name || '');
            $('#modal-phone-no').text(billing.patient.user?.phone || billing.patient_phone_number || '');
        } else {
            $('#modal-name').text(billing.patient_name || '');
            $('#modal-phone-no').text(billing.patient_phone_number || '');
        }
        
        $('#modal-billing-date').text(billing.sale_date || '');
        $('#modal-invoice').text(billing.invoice_no || '');
        $('#modal-payment-type').text(billing.payment_type || '');
        $('#modal-total-qty').text(billing.quantity || '');
        $('#modal-total-amt').text(billing.net_amount || '');
        $('#modal-total-gst').text(billing.gst_amount || '');
        $('#modal-total-discount').text(billing.discount || '');
        
        // 🟢 Build products list dynamically
        let productsHtml = '';
        if (billing.items && billing.items.length > 0) {
            productsHtml += `
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Batch</th>
                                <th>Qty</th>
                                <th>Price</th>
                                <th>Discount</th>
                                <th>GST</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            billing.items.forEach(item => {
                productsHtml += `
                    <tr>
                        <td>${item.product?.name || ''}</td>
                        <td>${item.batch?.batch_no || ''}</td>
                        <td>${item.quantity}</td>
                        <td>${item.price}</td>
                        <td>${item.discount}</td>
                        <td>${item.gst_amount}</td>
                        <td>${item.total}</td>
                    </tr>
                `;
            });

            productsHtml += `
                        </tbody>
                    </table>
                </div>
            `;
        } else {
            productsHtml = '<p class="text-muted">No items found.</p>';
        }

        $('#sales-products').html(productsHtml);

        // Show modal
        $('#billingModal').modal('show');
    });
    
    // Open modal for new billing
    $('#addBillingBtn').on('click', function () {
		$('#addBillingForm')[0].reset();
        $('#addBillingModal').modal('show');
    });
    
    // Function to calculate row total
	function calculateRowTotal(row) {
		let qty = parseInt(row.find('.quantity').val()) || 0;
		let price = parseFloat(row.find('.price').val()) || 0;
		let total = qty * price;
		row.find('.total').val(total.toFixed(2));
		calculateGrandTotal();
	}

	// Function to calculate grand total
	function calculateGrandTotal() {
		let grandTotal = 0;
		$('#medicine-container .medicine-row').each(function () {
			let total = parseFloat($(this).find('.total').val()) || 0;
			grandTotal += total;
		});
		$('#grand-total').text(grandTotal.toFixed(2));
	}

	// Add new medicine row
	$(document).on('click', '.add-medicine', function () {
		let rowIndex = $('#medicine-container .medicine-row').length;

		let newRow = `
			<div class="medicine-row row g-2 mb-2 position-relative">
				<input type="hidden" class="product-id" name="items[${rowIndex}][product_id]">
				<div class="col-md-4">
					<input type="text" class="form-control medicine-name" placeholder="Medicine name" required autocomplete="off">
				</div>
				<div class="col-md-2">
					<input type="number" class="form-control quantity" name="items[${rowIndex}][quantity]" placeholder="Qty" min="1" value="1" required>
				</div>
				<div class="col-md-2">
					<input type="text" class="form-control price" name="items[${rowIndex}][price]" placeholder="Price" readonly>
				</div>
				<div class="col-md-2">
					<input type="text" class="form-control total" name="items[${rowIndex}][total]" placeholder="Total" readonly>
				</div>
				<div class="col-md-2">
					<button type="button" class="btn btn-sm btn-danger remove-medicine">-</button>
				</div>
				<div class="col-12 mt-1 batch-container" style="display:none;">
					<select class="form-select batch-select" name="items[${rowIndex}][batch_id]"></select>
				</div>
			</div>`;
		$('#medicine-container').append(newRow);
	});

	// Remove medicine row
	$(document).on('click', '.remove-medicine', function () {
		$(this).closest('.medicine-row').remove();
		calculateGrandTotal();
	});

	// Quantity change event
	$(document).on('input', '.quantity', function () {
		calculateRowTotal($(this).closest('.medicine-row'));
	});

	const AUTH_TOKEN = localStorage.getItem('auth_token');
	const API_BASE_URL = document.querySelector('meta[name="api-base-url"]').getAttribute('content');

	// Medicine autocomplete (min 3 letters)
	$(document).on('input', '.medicine-name', function () {
		let input = $(this);
		let query = input.val();
		let row = input.closest('.medicine-row');

		if (query.length >= 3) {
			$.ajax({
				url: `${API_BASE_URL}/api/v1/admin/products/search`,
				headers: { Authorization: `Bearer ${AUTH_TOKEN}` },
				method: 'GET',
				data: { q: query },
				success: function (response) {
					let dropdown = $('<ul class="list-group position-absolute w-100"></ul>');

					response.forEach(function (medicine) {
						dropdown.append(
							`<li class="list-group-item medicine-option" 
								  data-id="${medicine.id}" 
								  data-name="${medicine.name.replace(/"/g, '&quot;')}" 
								  data-batches='${JSON.stringify(medicine.batches)}'>
								  ${medicine.name}
							 </li>`
						);
					});

					input.closest('.col-md-4').find('ul').remove();
					input.after(dropdown);
				}
			});
		} else {
			input.closest('.col-md-4').find('ul').remove();
		}
	});

	// Select medicine from autocomplete
	$(document).on('click', '.medicine-option', function () {
		/*let row = $(this).closest('.medicine-row');
		let name = $(this).data('name');
		let batches = $(this).data('batches');
		
		row.find('.medicine-name').val(name);
		row.find('ul').remove();

		if (batches.length > 1) {
			// Multiple batches → show dropdown
			let batchSelect = row.find('.batch-select');
			batchSelect.empty();

			batches.forEach(batch => {
				batchSelect.append(
					`<option value="${batch.id}" data-price="${batch.price}">
						Batch: ${batch.batch_no} | Price: ${batch.mrp} | Stock: ${batch.stock}
					 </option>`
				);
			});

			row.find('.batch-container').show();
			
			// set first batch price
			let firstPrice = batches[0].mrp;
			row.find('.price').val(firstPrice);
			row.find('.quantity').val(1);
			//alert(":: ROW VALUES ::"+JSON.stringify(row));
			calculateRowTotal(row);

		} else if (batches.length === 1) {
			// Single batch → directly set price
			let batch = batches[0];
			row.find('.price').val(batch.mrp);
			row.find('.quantity').val(1);
			row.find('.batch-container').hide();
			calculateRowTotal(row);
		} else {
			row.find('.price').val('');
			row.find('.batch-container').hide();
		}*/
		
		let $option = $(this);
		let medicineId = $option.data('id');
		let medicineName = $option.data('name');
		let batches = $option.data('batches'); // if you still need batches

		let row = $option.closest('.medicine-row');

		// ✅ update hidden product_id for this row
		row.find('.product-id').val(medicineId);

		// ✅ set medicine name into textbox
		row.find('.medicine-name').val(medicineName);

		// ✅ optionally set price from batch or default
		if (batches && batches.length > 0) {
			row.find('.price').val(batches[0].mrp);
			let qty = parseInt(row.find('.quantity').val()) || 1;
			row.find('.total').val((batches[0].mrp * qty).toFixed(2));
		}

		// remove dropdown after selection
		$option.parent().remove();
	});

	// When user changes batch from dropdown
	$(document).on('change', '.batch-select', function () {
		let row = $(this).closest('.medicine-row');
		let price = $(this).find(':selected').data('price');
		row.find('.price').val(price);
		calculateRowTotal(row);
	});
	
	// Submit AJAX
    $('#addBillingForm').on('submit', function (e) {
        e.preventDefault();

		$.ajax({
            //url: "http://127.0.0.1:8000/api/v1/admin/puchase",
            url: `${API_BASE_URL}/api/v1/billing/admin/sales`,
			headers: { Authorization: `Bearer ${AUTH_TOKEN}` },
            type: "POST",
            data: $(this).serialize(),
            success: function (response) {
				// ✅ Show success message
                alert("Purchase saved successfully!");

                // ✅ Close modal
                $('#addBillingModal').modal('hide');

                // (optional) reset form
                $('#purchaseForm')[0].reset();

                // (optional) reload data table / refresh list
                //loadPurchases();
                location.reload(); // ✅ refresh current page
            },
            error: function (xhr) {
				let errMsg = "Something went wrong!";
				if (xhr.responseJSON && xhr.responseJSON.message) {
					errMsg = xhr.responseJSON.message;
				}
				alert(errMsg);
			}
        });
    });
    
    /*function loadPurchases() {
		$.ajax({
			url: `${API_BASE_URL}/api/v1/billing/admin/sales`,
			headers: { Authorization: `Bearer ${AUTH_TOKEN}` },
			type: "GET",
			success: function (response) {
				let tbody = $("#billingTable tbody");
				tbody.empty(); // clear old rows

				if (response.data && response.data.length > 0) {
					response.data.forEach((sale, index) => {
						let billingData = JSON.stringify(sale).replace(/"/g, '&quot;'); // escape quotes for HTML
						let formattedDate = new Date(sale.sale_date).toLocaleDateString('en-GB');
						tbody.append(`
							<tr>
								<td>${index + 1}</td>
								<td>${sale.patient_name ?? "-"}</td>
								<td>${sale.patient_phone_number ?? "-"}</td>
								<td>${formattedDate}</td>
								<td>${sale.invoice_no}</td>
								<td>${sale.payment_type}</td>
								<td>${sale.payment_type}</td>
								<td>${sale.net_amount}</td>
								<td>${sale.gst_amount}</td>
								<td>
									<button class="btn btn-sm btn-outline-primary me-1 view-btn" 
											data-bs-toggle="modal" 
											data-bs-target="#billingModal" 
											data-billing="${billingData}">
										<i class="fas fa-eye"></i>
									</button>
								</td>
							</tr>
						`);
					});
				} else {
					tbody.append(`<tr><td colspan="7" class="text-center">No billing records found</td></tr>`);
				}
			},
			error: function (xhr) {
				console.error("Error loading sales:", xhr);
				$("#billingTable tbody").html(`<tr><td colspan="7" class="text-center text-danger">Failed to load data</td></tr>`);
			}
		});
	}*/
	
	function formatDate(dateStr) {
		let d = new Date(dateStr);
		let day = String(d.getDate()).padStart(2, '0');
		let month = String(d.getMonth() + 1).padStart(2, '0');
		let year = d.getFullYear();
		return `${day}-${month}-${year}`;
	}

});    
