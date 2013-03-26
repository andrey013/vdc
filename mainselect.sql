SELECT `t`.`id` AS `t0_c0`, `t`.`create_date` AS `t0_c1`, `t`.`global_number` AS `t0_c2`, `t`.`client_number` AS `t0_c3`, `t`.`client_id` AS `t0_c4`, `t`.`manager_id` AS `t0_c5`, `t`.`designer_id` AS `t0_c6`, `t`.`customer_id` AS `t0_c7`, `t`.`order_type_id` AS `t0_c8`, `t`.`difficulty_id` AS `t0_c9`, `t`.`priority_id` AS `t0_c10`, `t`.`comment` AS `t0_c11`, `t`.`chromaticity_id` AS `t0_c12`, `t`.`density_id` AS `t0_c13`, `t`.`size_x` AS `t0_c14`, `t`.`size_y` AS `t0_c15`, `t`.`measure_unit_id` AS `t0_c16`, `t`.`text` AS `t0_c17`, `t`.`designer_paid` AS `t0_c18`, `t`.`disabled` AS `t0_c19`, `client`.`id` AS `t1_c0`, `client`.`name` AS `t1_c1`, `client`.`code` AS `t1_c2`, `client`.`disabled` AS `t1_c3`, `orderType`.`id` AS `t2_c0`, `orderType`.`name` AS `t2_c1`, `orderType`.`disabled` AS `t2_c2`, `customer`.`id` AS `t3_c0`, `customer`.`name` AS `t3_c1`, `priority`.`id` AS `t4_c0`, `priority`.`name` AS `t4_c1`, `priority`.`code` AS `t4_c2`, `priority`.`sort_order` AS `t4_c3`, `priority`.`disabled` AS `t4_c4`, `payments`.`id` AS `t5_c0`, `payments`.`order_id` AS `t5_c1`, `payments`.`create_date` AS `t5_c2`, `payments`.`designer_price` AS `t5_c3`, `payments`.`client_price` AS `t5_c4`, `payments`.`debt` AS `t5_c5`, `user`.`id` AS `t6_c0`, `user`.`username` AS `t6_c1`, `user`.`email` AS `t6_c3`, `user`.`create_at` AS `t6_c5`, `user`.`lastvisit_at` AS `t6_c6`, `user`.`superuser` AS `t6_c7`, `user`.`status` AS `t6_c8`, `profile`.`user_id` AS `t7_c0`, `profile`.`lastname` AS `t7_c1`, `profile`.`firstname` AS `t7_c2`, `profile`.`client_id` AS `t7_c3`, `profile`.`user_status_id` AS `t7_c4` FROM `vdc_order` `t`  LEFT OUTER JOIN `vdc_client` `client` ON (`t`.`client_id`=`client`.`id`)  LEFT OUTER JOIN `vdc_order_type` `orderType` ON (`t`.`order_type_id`=`orderType`.`id`)  LEFT OUTER JOIN `vdc_customer` `customer` ON (`t`.`customer_id`=`customer`.`id`)  LEFT OUTER JOIN `vdc_priority` `priority` ON (`t`.`priority_id`=`priority`.`id`)  LEFT OUTER JOIN `vdc_payment` `payments` ON (`payments`.`order_id`=`t`.`id`)  LEFT OUTER JOIN `vdc_user` `user` ON (`t`.`manager_id`=`user`.`id`)  LEFT OUTER JOIN `vdc_profile` `profile` ON (`profile`.`user_id`=`user`.`id`)  WHERE (t.create_date between '2013-02-25 00:00:00' and '2013-03-27 00:00:00' and t.disabled=0);