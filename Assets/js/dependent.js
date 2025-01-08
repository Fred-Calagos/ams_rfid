function getMunicipalities(provCode) {
    $.ajax({
        type: "POST",
        url: "get_municipalities.php",
        data: { provCode: provCode },
        success: function (data) {
        $("#municipality").html(data);
        $("#barangay").html("<option value=''>Select Barangay</option>");
        }
    });
    }
function getMunicipalitiesEdit(provDesc) {
    $.ajax({
        type: "POST",
        url: "get_municipalities_edit.php",
        data: { prov_Desc: provDesc },
        success: function (data) {
        $("#municipality").html(data);
        $("#barangay").html("<option value=''>Select Barangay</option>");
        }
    });
    }

    function getBarangays(munCode) {
    $.ajax({
            type: "POST",
            url: "get_barangays.php",
            data: { munCode: munCode },
            success: function (data) {
            $("#barangay").html(data);
            }
        });
    }
    function getBarangaysEdit(munDesc) {
        $.ajax({
                type: "POST",
                url: "get_barangays_edit.php",
                data: { mun_desc: munDesc },
                success: function (data) {
                $("#barangay").html(data);
                }
            });
        }
function getGrade(gradeId) {
    console.log("Selected Grade: " + gradeId);
    $.ajax({
        type: "POST",
        url: "get_grade.php",
        data: { stud_grade: gradeId },
        success: function (data) {
        $("#section").html(data);
        }
    });
    }

    function getGradeEdit(gradeId) {
        console.log("Selected Grade: " + gradeId);
        $.ajax({
            type: "POST",
            url: "get_grade_edit.php",
            data: { stud_grade: gradeId },
            success: function (data) {
            $("#section").html(data);
            }
        });
        }
    

function getGrademul(val, gradeId) {
        console.log("Selected Grade: " + val);
        $.ajax({
            type: "POST",
            url: "get_grade_mul.php?total=" + gradeId,
            data: { stud_grade: val }, // Corrected parameter name
            success: function (data) {
                $("#section" + gradeId).html(data);
            }
        });
    }
    
    function getInsEdit(grEdit) {
        console.log("Select setion: " + grEdit)
        $.ajax({
                type: "POST",
                url: "get_insedit.php",
                data: { grEdit: grEdit },
                success: function (data) {
                $("#section").html(data);
                }
            });
        }
function getStrand(strandId) {
    console.log("Selected Strand: " + strandId);
    $.ajax({
        type: "POST",
        url: "get_strand.php",
        data: { strandId: strandId },
        success: function (data) {
        $("#strand").html(data);
        }
    });
}