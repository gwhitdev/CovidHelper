<?php

function applyPatientAuditActivity($dbc,$user_id,$patient_id,$activity) {
    $audit = "INSERT INTO patient_audit (activity,activity_date,patient_id,user_id)
                VALUES ('$activity',NOW(),'$patient_id','$user_id')";
    return $dbc->query($audit);
}
