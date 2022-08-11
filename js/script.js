const searchBook = () => {
	let filter = document.getElementById("searchBook").value.toUpperCase();
	let myTable = document.getElementById("bookTable");
	let tr = myTable.getElementsByTagName("tr");
	for (var i = 0; i < tr.length; i++) {
		let td = tr[i].getElementsByTagName("td")[2];
		if (td) {
			let textValue = td.textContent || td.innerHTML;
			if (textValue.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			} else {
				tr[i].style.display = "none";
			}
		}
	}
};

const searchUser = () => {
	let filter = document.getElementById("searchUser").value.toUpperCase();
	let myTable = document.getElementById("userTable");
	let tr = myTable.getElementsByTagName("tr");
	for (var i = 0; i < tr.length; i++) {
		let td = tr[i].getElementsByTagName("td")[1];
		if (td) {
			let textValue = td.textContent || td.innerHTML;
			if (textValue.toUpperCase().indexOf(filter) > -1) {
				tr[i].style.display = "";
			} else {
				tr[i].style.display = "none";
			}
		}
	}
};
