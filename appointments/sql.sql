SELECT * FROM `appointments` LEFT JOIN `employees` ON `appointments`.`employee_id` = `employees`.`employees_id` WHERE `appointments`.`employee_id` = '21363'

SELECT * FROM `appointments` 
LEFT JOIN `employees` ON `appointments`.`employee_id` = `employees`.`employees_id` 
LEFT JOIN `plantillas` ON `appointments`.`plantilla_id` = `plantillas`.`id`
LEFT JOIN `department` ON `plantillas`.`department_id` = `department`.`department_id`
WHERE `appointments`.`employee_id` = '21363'


SELECT * FROM `appointments` 
LEFT JOIN `employees` ON `appointments`.`employee_id` = `employees`.`employees_id` 
LEFT JOIN `plantillas` ON `appointments`.`plantilla_id` = `plantillas`.`id`
LEFT JOIN `department` ON `plantillas`.`department_id` = `department`.`department_id`
LEFT JOIN `positiontitles` ON `plantillas`.`position_id` = `positiontitles`.`position_id`
WHERE `appointments`.`employee_id` = '21363'

