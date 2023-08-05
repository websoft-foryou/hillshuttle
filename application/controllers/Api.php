<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH . '/libraries/Rest.php';
use REST;

class Api extends Rest {

    public function __construct() {
        parent::__construct();
    }

    public function get_test() {
        $this->response(array(
            'result' => true,
            'message' => 'success'
        ), 201);
    }

    public function post_register_booking() {
        $pickup_date = $this->convertDate($this->post('pickup_date'));
        $pickup_time = $this->post('pickup_time');
        $pickup_location = $this->post('pickup_location');
        $drop_off_location = $this->post('drop_off_location');
        $direction = $this->post('direction');
        $return_date = $this->convertDate($this->post('return_date'));
        $return_time = $this->post('return_time');
        $passengers = $this->post('passengers');
        $suitcases = $this->post('suitcases');
        $additional_luggage = $this->post('additional_luggage');
        $oversized_items = $this->post('oversized_items');
        $child_seat = $this->post('child_seat');
        $booking_comment = $this->post('booking_comment');
        $client_mobile = $this->post('client_mobile');
        $flight_number = $this->post('flight_number');
        $flight_time = $this->post('flight_time');

        $client_first_name = $this->post('client_first_name');
        $client_last_name = $this->post('client_last_name');
        $client_email = $this->post('client_email');
        $client_address = $this->post('client_address');
        $client_city = $this->post('client_city');

        $charge_amount = $this->post('charge_amount');
        $payment_method = $this->post('payment_id');

        if ($drop_off_location == 10415 || $drop_off_location == 10416 || $drop_off_location == 10417) $booking_type = 'AP';
        elseif ($drop_off_location == 10443) $booking_type = 'DH';
        elseif ($drop_off_location == 10444) $booking_type = 'CQ';
        elseif ($drop_off_location == 10445) $booking_type = 'CS';
        else $booking_type = 'Other';

        if ($drop_off_location == 10415 || $drop_off_location == 10416) $drop_off_location = 'Dom';
        elseif ($drop_off_location == 10417) $drop_off_location = 'Int';
        else $drop_off_location = '';

        if ($direction == 1) $direction = 'departure';      // one way
        elseif ($direction == 2) $direction = 'arrival';    // return
        else $direction = 'both';                           // return (new ride)

        if ($payment_method == 1) {
            $payment_method = 'cash';
            $paid_status = '2'; // driver
        }
        elseif ($payment_method == 2) {
            $payment_method = 'stripe';
            $paid_status = '1'; // office
        }
        else {
            $payment_method = 0;
            $paid_status = '0';
        }

        if ($direction == 'departure') {
            $dep_estfare = '$' . $charge_amount;
            $arr_estfare = '';
        }
        else {
            $dep_estfare = '$' . ($charge_amount / 2);
            $arr_estfare = '$' . ($charge_amount / 2);
        }

        $result = $this->db->get_where('clients', array('email' => $client_email))->row();
        if ($result) {
            $client_id = $result->id;
        }
        else {
            $this->db->insert('clients', array(
                'first_name' => $client_first_name,
                'last_name' => $client_last_name,
                'gender' => '',
                'address1' => $client_address,
                'address2' => '',
                'suburb' => $client_city,
                'state' => '',
                'phone' => '',
                'mobile' => $client_mobile,
                'email' => $client_email,
                'password' => md5('password'),
                'cli_type' => 1,
                'comments' => '',
                'created_by' => 'WP',
                'created_date' => date('Y-m-d H:i:s'),
                'updated_by' => 'WP',
                'updated_date' => date('Y-m-d H:i:s'),
            ));
            $client_id = $this->db->insert_id();
        }

        $locations = explode(',', $pickup_location);
        $comment = 'Suitcases: (' . $suitcases . ')' . chr(10) . chr(13);
        $comment .= 'Additional Luggage: (' . $additional_luggage . ')' . chr(10) . chr(13);
        $comment .= 'Oversized or Large and Bulky items: (' . $oversized_items . ')' . chr(10) . chr(13);
        $comment .= $booking_comment;

        $data = array(
            'client' => $client_id,
            'type' => $booking_type,
            'dep_date' => $pickup_date,
            'dep_pickuptime' => $pickup_time,
            'dep_address1' => count($locations) > 0 ? $locations[0] : '',
            'dep_suburb' => count($locations) > 1 ? $locations[1] : '',
            'dep_terminal' => $drop_off_location,
            'direction' => $direction,
            'arr_date' => is_null($return_date) ? '' : $return_date,
            'arr_pickuptime' => is_null($return_time) ? '' : $return_time,
            'dep_passengers' => $passengers,
            'dep_babyseats' => $child_seat,
            'dep_comments' => $comment,
            'dep_mobile' => $client_mobile,
            'dep_flight' => $flight_number,
            'dep_ourtime' => $flight_time,
            'payment_method' => $payment_method,
            'dep_estfare' => $dep_estfare,
            'arr_address1' => $direction != 'departure' && count($locations) > 0 ? $locations[0] : '',
            'arr_suburb' => $direction != 'departure' && count($locations) > 1 ? $locations[1] : '',
            'arr_terminal' => $direction != 'departure' ? $drop_off_location : '',
            'arr_estfare' => $arr_estfare,
            'arr_passengers' => $direction != 'departure' ? $passengers : '',
            'arr_babyseats' => $direction != 'departure' ? $child_seat : '',
            'arr_comments' => $direction != 'departure' ? $comment : '',
            'arr_mobile' => $direction != 'departure' ? $client_mobile : '',
            'arr_flight' => $direction != 'departure' ? $flight_number : '',
            'arr_ourtime' => $direction != 'departure' ? $flight_time : '',
            'paid_status' => $paid_status,
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => 'wordpress',
            'updated_date' => date('Y-m-d H:i:s'),
            'updated_by' => 'wordpress',
        );

        $this->db->insert('booking', $data);
        $this->response(array(
            'status' => true,
            'message' => $client_id,
            'data' => $data
        ), 201);

    }

    private function convertDate($date)
    {
        if ($date == '' || is_null($date)) return '';

        $original_date = DateTime::createFromFormat('d-m-Y', $date);
        $formatted_date = $original_date->format('Y-m-d');

        return $formatted_date;
    }
}

?>