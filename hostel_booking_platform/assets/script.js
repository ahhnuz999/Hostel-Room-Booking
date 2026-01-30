function checkAvailability() {
    const roomId   = document.getElementById("room_id").value;
    const checkIn  = document.getElementById("check_in").value;
    const checkOut = document.getElementById("check_out").value;

    if (!roomId || !checkIn || !checkOut) return;

    fetch("ajax_check_availability.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body:
            "room_id=" + roomId +
            "&check_in=" + checkIn +
            "&check_out=" + checkOut
    })
    .then(res => res.text())
    .then(data => {
        document.getElementById("availability_status").innerHTML = data;
    });
}
