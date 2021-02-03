function change(id, entreprise) {
    for (i = 1; i
    <= 5; i++) {
        bidule = document.getElementById(entreprise);
        if (i
    <= id){
            bidule.querySelector("#_" + i).classList.add("checked");
        } else if (i > id) {
            bidule.querySelector("#_" + i).classList.remove("checked");
        }
    }
}
