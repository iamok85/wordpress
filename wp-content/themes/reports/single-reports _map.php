<?php
/**
 * The template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */

get_header('reports'); ?>

	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

		   <script>
				var appWebRoot="/search_template.new/index.php/";
			</script>	

			<style>
 #map-canvas {
  height: 90%;
}
</style>

  
    <script>
		var appWebRoot="/search_template.new/index.php/";		
	</script>	
	
	<script type="text/javascript"
		src="http://maps.googleapis.com/maps/api/js?key=AIzaSyCfeQCllzZWaN8HcqP8QsxJp5UqGzPkWjg&sensor=false&libraries=places">
	</script>
	<script type="text/javascript" src="http://google-maps-utility-library-v3.googlecode.com/svn/trunk/markerclustererplus/src/markerclusterer.js"></script>	
	<script type="text/javascript" src="/search_template.new/js/result_map.js"></script>		
	
	
	
	
<strong>Click the map marker to see data slice </strong>
<div class="graph">	
	
	           	
			  
					    								<input type="hidden" value="Product Name" class="graph_title products_productName" />							  
				<div class="statistics_store products_productName">
															
																					
												  <input type="hidden" class="label 1 products_productName" value="Barcelona__Rambla de Catalu?a, 23"/>						  
						  <input type="hidden" class="geolocation 1 products_productName" value="41.3888287,2.1662708"/>
						  <input type="hidden" class="group_stats 1 products_productName" value="22"/>
						  						  <input type="hidden" class="data_slice_link 1 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Barcelona__Rambla+de+Catalu%5Cu00f1a%2C+23%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 2 products_productName" value="Bruxelles__Rue Joseph-Bens 532"/>						  
						  <input type="hidden" class="geolocation 2 products_productName" value="50.8070375,4.3332521"/>
						  <input type="hidden" class="group_stats 2 products_productName" value="20"/>
						  						  <input type="hidden" class="data_slice_link 2 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Bruxelles__Rue+Joseph-Bens+532%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																					
												  <input type="hidden" class="label 4 products_productName" value="Montr¨¦al__43 rue St. Laurent"/>						  
						  <input type="hidden" class="geolocation 4 products_productName" value="45.5389598,-73.5054279"/>
						  <input type="hidden" class="group_stats 4 products_productName" value="22"/>
						  						  <input type="hidden" class="data_slice_link 4 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Montr%5Cu00e9al__43+rue+St.+Laurent%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																					
												  <input type="hidden" class="label 6 products_productName" value="Oulu__Torikatu 38"/>						  
						  <input type="hidden" class="geolocation 6 products_productName" value="65.010279,25.4650189"/>
						  <input type="hidden" class="group_stats 6 products_productName" value="31"/>
						  						  <input type="hidden" class="data_slice_link 6 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Oulu__Torikatu+38%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																					
												  <input type="hidden" class="label 8 products_productName" value="South Brisbane__31 Duncan St. West End"/>						  
						  <input type="hidden" class="geolocation 8 products_productName" value="-27.4847009,152.99974"/>
						  <input type="hidden" class="group_stats 8 products_productName" value="15"/>
						  						  <input type="hidden" class="data_slice_link 8 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22South+Brisbane__31+Duncan+St.+West+End%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																					
												  <input type="hidden" class="label 10 products_productName" value="Tsawassen__23 Tsawassen Blvd."/>						  
						  <input type="hidden" class="geolocation 10 products_productName" value="49.0301179,-123.0977358"/>
						  <input type="hidden" class="group_stats 10 products_productName" value="26"/>
						  						  <input type="hidden" class="data_slice_link 10 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Tsawassen__23+Tsawassen+Blvd.%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 11 products_productName" value="Paris__27 rue du Colonel Pierre Avia"/>						  
						  <input type="hidden" class="geolocation 11 products_productName" value="48.829493,2.2758216"/>
						  <input type="hidden" class="group_stats 11 products_productName" value="20"/>
						  						  <input type="hidden" class="data_slice_link 11 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Paris__27+rue+du+Colonel+Pierre+Avia%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 12 products_productName" value="Reims__59 rue de l'Abbaye"/>						  
						  <input type="hidden" class="geolocation 12 products_productName" value="49.2558334,4.1554039"/>
						  <input type="hidden" class="group_stats 12 products_productName" value="37"/>
						  						  <input type="hidden" class="data_slice_link 12 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Reims__59+rue+de+l%27Abbaye%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 13 products_productName" value="Newark__7476 Moss Rd."/>						  
						  <input type="hidden" class="geolocation 13 products_productName" value="39.6958651,-75.733876"/>
						  <input type="hidden" class="group_stats 13 products_productName" value="21"/>
						  						  <input type="hidden" class="data_slice_link 13 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Newark__7476+Moss+Rd.%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 14 products_productName" value="Nantes__67, rue des Cinquante Otages"/>						  
						  <input type="hidden" class="geolocation 14 products_productName" value="47.218586,-1.557082"/>
						  <input type="hidden" class="group_stats 14 products_productName" value="43"/>
						  						  <input type="hidden" class="data_slice_link 14 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Nantes__67%2C+rue+des+Cinquante+Otages%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																					
												  <input type="hidden" class="label 16 products_productName" value="Munich__Hansastr. 15"/>						  
						  <input type="hidden" class="geolocation 16 products_productName" value="48.13472,11.52624"/>
						  <input type="hidden" class="group_stats 16 products_productName" value="14"/>
						  						  <input type="hidden" class="data_slice_link 16 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Munich__Hansastr.+15%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																					
												  <input type="hidden" class="label 18 products_productName" value="NYC__5290 North Pendale Street__Suite 200"/>						  
						  <input type="hidden" class="geolocation 18 products_productName" value="40.5597928,-74.1220081"/>
						  <input type="hidden" class="group_stats 18 products_productName" value="10"/>
						  						  <input type="hidden" class="data_slice_link 18 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22NYC__5290+North+Pendale+Street__Suite+200%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																					
																					
												  <input type="hidden" class="label 21 products_productName" value="Auckland  __Arenales 1938 3'A'"/>						  
						  <input type="hidden" class="geolocation 21 products_productName" value="-36.8484597,174.7633315"/>
						  <input type="hidden" class="group_stats 21 products_productName" value="45"/>
						  						  <input type="hidden" class="data_slice_link 21 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Auckland++__Arenales+1938+3%27A%27%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																					
												  <input type="hidden" class="label 23 products_productName" value="London__120 Hanover Sq."/>						  
						  <input type="hidden" class="geolocation 23 products_productName" value="51.5135277,-0.1438117"/>
						  <input type="hidden" class="group_stats 23 products_productName" value="12"/>
						  						  <input type="hidden" class="data_slice_link 23 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22London__120+Hanover+Sq.%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 24 products_productName" value="Melbourne__636 St Kilda Road__Level 3"/>						  
						  <input type="hidden" class="geolocation 24 products_productName" value="-37.85486,144.981608"/>
						  <input type="hidden" class="group_stats 24 products_productName" value="40"/>
						  						  <input type="hidden" class="data_slice_link 24 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Melbourne__636+St+Kilda+Road__Level+3%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																					
												  <input type="hidden" class="label 26 products_productName" value="Pasadena__78934 Hillside Dr."/>						  
						  <input type="hidden" class="geolocation 26 products_productName" value="34.1771951,-118.22569"/>
						  <input type="hidden" class="group_stats 26 products_productName" value="29"/>
						  						  <input type="hidden" class="data_slice_link 26 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Pasadena__78934+Hillside+Dr.%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 27 products_productName" value="New Bedford__4575 Hillside Dr."/>						  
						  <input type="hidden" class="geolocation 27 products_productName" value="41.5912958,-70.9409528"/>
						  <input type="hidden" class="group_stats 27 products_productName" value="34"/>
						  						  <input type="hidden" class="data_slice_link 27 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22New+Bedford__4575+Hillside+Dr.%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																					
																					
												  <input type="hidden" class="label 30 products_productName" value="Sevilla__C/ Romero, 33"/>						  
						  <input type="hidden" class="geolocation 30 products_productName" value="37.4076967,-5.9723496"/>
						  <input type="hidden" class="group_stats 30 products_productName" value="15"/>
						  						  <input type="hidden" class="data_slice_link 30 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Sevilla__C%5C%2F+Romero%2C+33%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 31 products_productName" value="Toulouse__1 rue Alsace-Lorraine"/>						  
						  <input type="hidden" class="geolocation 31 products_productName" value="43.5996235,1.4454683"/>
						  <input type="hidden" class="group_stats 31 products_productName" value="20"/>
						  						  <input type="hidden" class="data_slice_link 31 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Toulouse__1+rue+Alsace-Lorraine%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 32 products_productName" value="Reggio Emilia__Strada Provinciale 124"/>						  
						  <input type="hidden" class="geolocation 32 products_productName" value="43.8049872,11.8319005"/>
						  <input type="hidden" class="group_stats 32 products_productName" value="39"/>
						  						  <input type="hidden" class="data_slice_link 32 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Reggio+Emilia__Strada+Provinciale+124%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 33 products_productName" value="Helsinki__Keskuskatu 45"/>						  
						  <input type="hidden" class="geolocation 33 products_productName" value="60.1700589,24.942781"/>
						  <input type="hidden" class="group_stats 33 products_productName" value="30"/>
						  						  <input type="hidden" class="data_slice_link 33 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Helsinki__Keskuskatu+45%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 34 products_productName" value="Lille__184, chauss¨¦e de Tournai"/>						  
						  <input type="hidden" class="geolocation 34 products_productName" value="50.621652,3.0877659"/>
						  <input type="hidden" class="group_stats 34 products_productName" value="14"/>
						  						  <input type="hidden" class="data_slice_link 34 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Lille__184%2C+chauss%5Cu00e9e+de+Tournai%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 35 products_productName" value="Graz__Kirchgasse 6"/>						  
						  <input type="hidden" class="geolocation 35 products_productName" value="47.0812283,15.4397936"/>
						  <input type="hidden" class="group_stats 35 products_productName" value="15"/>
						  						  <input type="hidden" class="data_slice_link 35 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Graz__Kirchgasse+6%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 36 products_productName" value="Vancouver__1900 Oak St."/>						  
						  <input type="hidden" class="geolocation 36 products_productName" value="49.2659879,-123.1264858"/>
						  <input type="hidden" class="group_stats 36 products_productName" value="19"/>
						  						  <input type="hidden" class="data_slice_link 36 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Vancouver__1900+Oak+St.%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																					
												  <input type="hidden" class="label 38 products_productName" value="Madrid__C/ Araquil, 67"/>						  
						  <input type="hidden" class="geolocation 38 products_productName" value="40.4605267,-3.779942"/>
						  <input type="hidden" class="group_stats 38 products_productName" value="26"/>
						  						  <input type="hidden" class="data_slice_link 38 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Madrid__C%5C%2F+Araquil%2C+67%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																					
																					
												  <input type="hidden" class="label 41 products_productName" value="Kita-ku__1-6-20 Dojima"/>						  
						  <input type="hidden" class="geolocation 41 products_productName" value="34.6969817,135.496446"/>
						  <input type="hidden" class="group_stats 41 products_productName" value="20"/>
						  						  <input type="hidden" class="data_slice_link 41 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Kita-ku__1-6-20+Dojima%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 42 products_productName" value="San Jose__3086 Ingle Ln."/>						  
						  <input type="hidden" class="geolocation 42 products_productName" value="27.9986702,-15.445546"/>
						  <input type="hidden" class="group_stats 42 products_productName" value="39"/>
						  						  <input type="hidden" class="data_slice_link 42 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22San+Jose__3086+Ingle+Ln.%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 43 products_productName" value="Makati City__15 McCallum Street__NatWest Center #13-03"/>						  
						  <input type="hidden" class="geolocation 43 products_productName" value="14.554729,121.0244452"/>
						  <input type="hidden" class="group_stats 43 products_productName" value="22"/>
						  						  <input type="hidden" class="data_slice_link 43 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Makati+City__15+McCallum+Street__NatWest+Center+%2313-03%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 44 products_productName" value="K?ln__Mehrheimerstr. 369"/>						  
						  <input type="hidden" class="geolocation 44 products_productName" value="50.9734578,6.9460623"/>
						  <input type="hidden" class="group_stats 44 products_productName" value="17"/>
						  						  <input type="hidden" class="data_slice_link 44 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22K%5Cu00f6ln__Mehrheimerstr.+369%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																					
												  <input type="hidden" class="label 46 products_productName" value="Auckland  __162-164 Grafton Road__Level 2"/>						  
						  <input type="hidden" class="geolocation 46 products_productName" value="-36.8484597,174.7633315"/>
						  <input type="hidden" class="group_stats 46 products_productName" value="42"/>
						  						  <input type="hidden" class="data_slice_link 46 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Auckland++__162-164+Grafton+Road__Level+2%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																					
												  <input type="hidden" class="label 48 products_productName" value="Burlingame__9408 Furth Circle"/>						  
						  <input type="hidden" class="geolocation 48 products_productName" value="45.4568931,-122.6827929"/>
						  <input type="hidden" class="group_stats 48 products_productName" value="30"/>
						  						  <input type="hidden" class="data_slice_link 48 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Burlingame__9408+Furth+Circle%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																					
												  <input type="hidden" class="label 50 products_productName" value="Paris__25, rue Lauriston"/>						  
						  <input type="hidden" class="geolocation 50 products_productName" value="48.8711159,2.2919884"/>
						  <input type="hidden" class="group_stats 50 products_productName" value="18"/>
						  						  <input type="hidden" class="data_slice_link 50 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Paris__25%2C+rue+Lauriston%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 51 products_productName" value="Liverpool__12, Berkeley Gardens Blvd"/>						  
						  <input type="hidden" class="geolocation 51 products_productName" value="38.0849716,-78.4708758"/>
						  <input type="hidden" class="group_stats 51 products_productName" value="29"/>
						  						  <input type="hidden" class="data_slice_link 51 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Liverpool__12%2C+Berkeley+Gardens+Blvd%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 52 products_productName" value="Marseille__12, rue des Bouchers"/>						  
						  <input type="hidden" class="geolocation 52 products_productName" value="43.3511321,5.4393425"/>
						  <input type="hidden" class="group_stats 52 products_productName" value="24"/>
						  						  <input type="hidden" class="data_slice_link 52 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Marseille__12%2C+rue+des+Bouchers%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 53 products_productName" value="Frankfurt__Lyonerstr. 34"/>						  
						  <input type="hidden" class="geolocation 53 products_productName" value="50.07833,8.62353"/>
						  <input type="hidden" class="group_stats 53 products_productName" value="22"/>
						  						  <input type="hidden" class="data_slice_link 53 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Frankfurt__Lyonerstr.+34%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 54 products_productName" value="Lyon__2, rue du Commerce"/>						  
						  <input type="hidden" class="geolocation 54 products_productName" value="45.7712203,4.9208119"/>
						  <input type="hidden" class="group_stats 54 products_productName" value="41"/>
						  						  <input type="hidden" class="data_slice_link 54 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Lyon__2%2C+rue+du+Commerce%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 55 products_productName" value="Bridgewater__25593 South Bay Ln."/>						  
						  <input type="hidden" class="geolocation 55 products_productName" value="40.5368792,-74.4904523"/>
						  <input type="hidden" class="group_stats 55 products_productName" value="25"/>
						  						  <input type="hidden" class="data_slice_link 55 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Bridgewater__25593+South+Bay+Ln.%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																					
												  <input type="hidden" class="label 57 products_productName" value="Los Angeles__6047 Douglas Av."/>						  
						  <input type="hidden" class="geolocation 57 products_productName" value="33.9345464,-118.3835068"/>
						  <input type="hidden" class="group_stats 57 products_productName" value="14"/>
						  						  <input type="hidden" class="data_slice_link 57 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Los+Angeles__6047+Douglas+Av.%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																					
																					
												  <input type="hidden" class="label 60 products_productName" value="Nantes__54, rue Royale"/>						  
						  <input type="hidden" class="geolocation 60 products_productName" value="47.2143641,-1.5578819"/>
						  <input type="hidden" class="group_stats 60 products_productName" value="7"/>
						  						  <input type="hidden" class="data_slice_link 60 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Nantes__54%2C+rue+Royale%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 61 products_productName" value="Philadelphia__11328 Douglas Av."/>						  
						  <input type="hidden" class="geolocation 61 products_productName" value="40.08858,-75.1885644"/>
						  <input type="hidden" class="group_stats 61 products_productName" value="17"/>
						  						  <input type="hidden" class="data_slice_link 61 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Philadelphia__11328+Douglas+Av.%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																					
												  <input type="hidden" class="label 63 products_productName" value="London__35 King George"/>						  
						  <input type="hidden" class="geolocation 63 products_productName" value="51.4760276,-0.0090818"/>
						  <input type="hidden" class="group_stats 63 products_productName" value="26"/>
						  						  <input type="hidden" class="data_slice_link 63 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22London__35+King+George%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 64 products_productName" value="Versailles__67, avenue de l'Europe"/>						  
						  <input type="hidden" class="geolocation 64 products_productName" value="48.8041737,2.1306178"/>
						  <input type="hidden" class="group_stats 64 products_productName" value="17"/>
						  						  <input type="hidden" class="data_slice_link 64 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Versailles__67%2C+avenue+de+l%27Europe%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 65 products_productName" value="NYC__2678 Kingston Rd.__Suite 101"/>						  
						  <input type="hidden" class="geolocation 65 products_productName" value="40.6684629,-73.9422841"/>
						  <input type="hidden" class="group_stats 65 products_productName" value="25"/>
						  						  <input type="hidden" class="data_slice_link 65 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22NYC__2678+Kingston+Rd.__Suite+101%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 66 products_productName" value="Auckland__199 Great North Road"/>						  
						  <input type="hidden" class="geolocation 66 products_productName" value="-36.8637763,174.7474686"/>
						  <input type="hidden" class="group_stats 66 products_productName" value="26"/>
						  						  <input type="hidden" class="data_slice_link 66 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Auckland__199+Great+North+Road%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 67 products_productName" value="Cambridge__39323 Spinnaker Dr."/>						  
						  <input type="hidden" class="geolocation 67 products_productName" value="38.1995098,-85.5988781"/>
						  <input type="hidden" class="group_stats 67 products_productName" value="27"/>
						  						  <input type="hidden" class="data_slice_link 67 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Cambridge__39323+Spinnaker+Dr.%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 68 products_productName" value="NYC__4092 Furth Circle__Suite 400"/>						  
						  <input type="hidden" class="geolocation 68 products_productName" value="40.6515845,-74.0074002"/>
						  <input type="hidden" class="group_stats 68 products_productName" value="32"/>
						  						  <input type="hidden" class="data_slice_link 68 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22NYC__4092+Furth+Circle__Suite+400%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 69 products_productName" value="Cambridge__4658 Baden Av."/>						  
						  <input type="hidden" class="geolocation 69 products_productName" value="43.4099622,-80.403372"/>
						  <input type="hidden" class="group_stats 69 products_productName" value="11"/>
						  						  <input type="hidden" class="data_slice_link 69 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Cambridge__4658+Baden+Av.%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 70 products_productName" value="Charleroi__Boulevard Tirou, 255"/>						  
						  <input type="hidden" class="geolocation 70 products_productName" value="50.4062714,4.447026"/>
						  <input type="hidden" class="group_stats 70 products_productName" value="8"/>
						  						  <input type="hidden" class="data_slice_link 70 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Charleroi__Boulevard+Tirou%2C+255%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 71 products_productName" value="Dublin__25 Maiden Lane__Floor No. 4"/>						  
						  <input type="hidden" class="geolocation 71 products_productName" value="32.5385294,-82.909692"/>
						  <input type="hidden" class="group_stats 71 products_productName" value="16"/>
						  						  <input type="hidden" class="data_slice_link 71 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Dublin__25+Maiden+Lane__Floor+No.+4%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 72 products_productName" value="Paris__265, boulevard Charonne"/>						  
						  <input type="hidden" class="geolocation 72 products_productName" value="48.8579118,2.3921071"/>
						  <input type="hidden" class="group_stats 72 products_productName" value="22"/>
						  						  <input type="hidden" class="data_slice_link 72 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Paris__265%2C+boulevard+Charonne%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 73 products_productName" value="New Bedford__1785 First Street"/>						  
						  <input type="hidden" class="geolocation 73 products_productName" value="41.614619,-70.920005"/>
						  <input type="hidden" class="group_stats 73 products_productName" value="26"/>
						  						  <input type="hidden" class="data_slice_link 73 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22New+Bedford__1785+First+Street%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																					
												  <input type="hidden" class="label 75 products_productName" value="San Diego__361 Furth Circle"/>						  
						  <input type="hidden" class="geolocation 75 products_productName" value="27.755258,-98.2446127"/>
						  <input type="hidden" class="group_stats 75 products_productName" value="25"/>
						  						  <input type="hidden" class="data_slice_link 75 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22San+Diego__361+Furth+Circle%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 76 products_productName" value="Burbank__3675 Furth Circle"/>						  
						  <input type="hidden" class="geolocation 76 products_productName" value="34.2335623,-118.2594829"/>
						  <input type="hidden" class="group_stats 76 products_productName" value="13"/>
						  						  <input type="hidden" class="data_slice_link 76 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Burbank__3675+Furth+Circle%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 77 products_productName" value="North Sydney__201 Miller Street__Level 15"/>						  
						  <input type="hidden" class="geolocation 77 products_productName" value="-33.836335,151.207382"/>
						  <input type="hidden" class="group_stats 77 products_productName" value="41"/>
						  						  <input type="hidden" class="data_slice_link 77 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22North+Sydney__201+Miller+Street__Level+15%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																					
												  <input type="hidden" class="label 79 products_productName" value="Philadelphia__782 First Street"/>						  
						  <input type="hidden" class="geolocation 79 products_productName" value="40.092678,-75.255947"/>
						  <input type="hidden" class="group_stats 79 products_productName" value="21"/>
						  						  <input type="hidden" class="data_slice_link 79 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Philadelphia__782+First+Street%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 80 products_productName" value="Brisbane__2793 Furth Circle"/>						  
						  <input type="hidden" class="geolocation 80 products_productName" value="37.6577593,-122.4193696"/>
						  <input type="hidden" class="group_stats 80 products_productName" value="15"/>
						  						  <input type="hidden" class="data_slice_link 80 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Brisbane__2793+Furth+Circle%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 81 products_productName" value="Las Vegas__8489 Strong St."/>						  
						  <input type="hidden" class="geolocation 81 products_productName" value="36.3033074,-115.2624992"/>
						  <input type="hidden" class="group_stats 81 products_productName" value="24"/>
						  						  <input type="hidden" class="data_slice_link 81 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Las+Vegas__8489+Strong+St.%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 82 products_productName" value="Glen Waverly__7 Allen Street"/>						  
						  <input type="hidden" class="geolocation 82 products_productName" value="-37.88672,145.16157"/>
						  <input type="hidden" class="group_stats 82 products_productName" value="23"/>
						  						  <input type="hidden" class="data_slice_link 82 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Glen+Waverly__7+Allen+Street%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 83 products_productName" value="Milan__20093 Cologno Monzese__Alessandro Volta 16"/>						  
						  <input type="hidden" class="geolocation 83 products_productName" value="45.5246968,9.2850871"/>
						  <input type="hidden" class="group_stats 83 products_productName" value="8"/>
						  						  <input type="hidden" class="data_slice_link 83 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Milan__20093+Cologno+Monzese__Alessandro+Volta+16%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																					
																					
																					
																					
												  <input type="hidden" class="label 88 products_productName" value="Strasbourg__24, place Kl¨¦ber"/>						  
						  <input type="hidden" class="geolocation 88 products_productName" value="48.5834375,7.7448033"/>
						  <input type="hidden" class="group_stats 88 products_productName" value="19"/>
						  						  <input type="hidden" class="data_slice_link 88 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Strasbourg__24%2C+place+Kl%5Cu00e9ber%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 89 products_productName" value="Br?cke__?kergatan 24"/>						  
						  <input type="hidden" class="geolocation 89 products_productName" value="57.7163146,11.9254422"/>
						  <input type="hidden" class="group_stats 89 products_productName" value="38"/>
						  						  <input type="hidden" class="data_slice_link 89 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Br%5Cu00e4cke__%5Cu00c5kergatan+24%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 90 products_productName" value="Madrid__C/ Moralzarzal, 86"/>						  
						  <input type="hidden" class="geolocation 90 products_productName" value="40.4938993,-3.7123061"/>
						  <input type="hidden" class="group_stats 90 products_productName" value="106"/>
						  						  <input type="hidden" class="data_slice_link 90 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Madrid__C%5C%2F+Moralzarzal%2C+86%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 91 products_productName" value="Boston__8616 Spinnaker Dr."/>						  
						  <input type="hidden" class="geolocation 91 products_productName" value="42.3007723,-70.8962535"/>
						  <input type="hidden" class="group_stats 91 products_productName" value="21"/>
						  						  <input type="hidden" class="data_slice_link 91 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Boston__8616+Spinnaker+Dr.%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 92 products_productName" value="Glendale__4097 Douglas Av."/>						  
						  <input type="hidden" class="geolocation 92 products_productName" value="43.1306584,-87.9639019"/>
						  <input type="hidden" class="group_stats 92 products_productName" value="3"/>
						  						  <input type="hidden" class="data_slice_link 92 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Glendale__4097+Douglas+Av.%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 93 products_productName" value="Minato-ku__2-2-8 Roppongi"/>						  
						  <input type="hidden" class="geolocation 93 products_productName" value="35.6672833,139.7387306"/>
						  <input type="hidden" class="group_stats 93 products_productName" value="32"/>
						  						  <input type="hidden" class="data_slice_link 93 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Minato-ku__2-2-8+Roppongi%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
												  <input type="hidden" class="label 94 products_productName" value="Torino__Via Monte Bianco 34"/>						  
						  <input type="hidden" class="geolocation 94 products_productName" value="45.015025,7.666591"/>
						  <input type="hidden" class="group_stats 94 products_productName" value="26"/>
						  						  <input type="hidden" class="data_slice_link 94 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Torino__Via+Monte+Bianco+34%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																					
												  <input type="hidden" class="label 96 products_productName" value="Central Hong Kong__Bank of China Tower__1 Garden Road"/>						  
						  <input type="hidden" class="geolocation 96 products_productName" value="22.2793043,114.1614931"/>
						  <input type="hidden" class="group_stats 96 products_productName" value="12"/>
						  						  <input type="hidden" class="data_slice_link 96 products_productName" value="search_query_get_data?url=save_ajax&sid=557e71b1719f9&filters_groups=%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%2C%7B%22geolocation_place_name%22%3A%5B%22Central+Hong+Kong__Bank+of+China+Tower__1+Garden+Road%22%5D%7D%5D%5D&options=%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
																					
																				</div>
													<div class="map-canvas products_productName" style="width:900px;height:500px">
				  
				</div>
							  
</div>
 	<div class="total_sql_display_div" style="display:none;">
			
				<pre>select CONCAT(IFNULL(Customers.city,""),"__",IFNULL(Customers.addressLine1,""),"__",IFNULL(Customers.addressLine2,"")) as as_field,count(distinct IFNULL(Products.productName,"")) AS count_field,GROUP_CONCAT(IFNULL(Products.productName,"") SEPARATOR ',') AS group_concat_field from products Products   INNER JOIN orderdetails Orderdetails on Orderdetails.productCode = Products.productCode INNER JOIN orders Orders on Orders.orderNumber = Orderdetails.orderNumber INNER JOIN customers Customers on Customers.customerNumber = Orders.customerNumber INNER JOIN employees Employees on Employees.employeeNumber = Customers.salesRepEmployeeNumber  INNER JOIN geolocation Geolocation on Geolocation.pk_value = Customers.customerNumber  where (true) group by IFNULL(Customers.city,""),IFNULL(Customers.addressLine1,""),IFNULL(Customers.addressLine2,"") order by Products.productName desc</pre>		
	</div>	
 
 <div class="modal_data_slice"> </div>
	 
	<input type="hidden" class="options_str" value="%7B%22render_type%22%3A%22table%22%2C%22list_by%22%3A%5B%22makeup_Customer_Address%22%5D%2C%22compare_with%22%3A%5B%7B%22logic_field%22%3A%22products_productName%22%2C%22compare_function%22%3A%5B%5D%7D%5D%2C%22order_by%22%3A%22products_productName%22%2C%22order_by_seq%22%3A%22desc%22%2C%22pagination%22%3A%2220%22%2C%22show_sql_only%22%3A0%2C%22use_sub_query%22%3A0%2C%22combine%22%3A0%2C%22view_type%22%3A%22557e71b1719f9%22%7D"/>
	<input type="hidden" class="filter_groups_str" value="%5B%5B%7B%22customers_customerNumber%22%3A%5B%5D%7D%5D%5D" />
	<input type="hidden" class="appDomain" value="/search_template.new" />

			
		</div><!-- #content -->
	</div><!-- #primary -->

<?php //get_sidebar(); ?>
<?php get_footer('reports'); ?>