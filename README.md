# SoftwareSecurity
————————————————————————————————————————————————————————————————————————————————————————
Read me for sql_inj_prevent_lib.php
————————————————————————————————————————————————————————————————————————————————————————

1. Include the library into the php code of the site using require statement.
2. Use the functions in the library in your php code.
	a) Use tag_str for all the user inputs
	b) Change the following functions if present in your code:

	mysql_query() - > mysql_iquery()
	mysqli_result -> mysql_iresult
	mysqli_num_rows() -> mysql_inum_rows()
	mysqli_filed_tell() -> mysql_ifield_tell()
	mysqli_field_count() -> mysql_ifield_count()
	mysqli_field_seek() ->  mysql_ifield_seek()
	mysqli_field_tell() -> mysql_ifield_tell()


3. If any procedural functions of mysqli_result are being used, replace them with following.
	a. mysqli_fetch_all() ->  mysql_ifetch_all()
	b. mysqli_fetch_array()-> mysql_ifetch_array()
	c. mysqli_fetch_assoc()-> mysql_ifetch_assoc()
	d. mysqli_fetch_field_direct() -> mysql_ifetch_field_direct() 
	e. mysqli_fetch_field()->  mysql_ifetch_field()
	f. mysqli_fetch_fields() -> mysql_ifetch_fields()
	g. mysqli_fetch_lengths() -> mysql_ifetch_lengths() 		
	h. mysqli_fetch_object() -> mysql_ifetch_object() 
	i. mysqli_fetch_row() -> mysql_ifetch_row()

4. Make sure that the data retrieved using fetch_[object|row|assoc|array|all]_toDisplay() should be re tagged again.
