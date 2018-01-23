
$(document).ready(function () {
    $("input[type=checkbox]").click(function (e) {
        if ($(e.currentTarget).closest("div.playerlist").length > 0) {
            toggleInputs($(e.currentTarget).closest("div.playerlist")[0]);        
        }
    });
});

function toggleInputs(playerlistElement) {
    if ($(playerlistElement).data('max-answers') == undefined) {
        return true;
    } else {
        maxAnswers = parseInt($(playerlistElement).data('max-answers'), 10); 
        if ($(playerlistElement).find(":checked").length >= maxAnswers) {
            $(playerlistElement).find(":not(:checked)").attr("disabled", true);
        } else {
            $(playerlistElement).find("input[type=checkbox]").attr("disabled", false);
        }
    }
}
