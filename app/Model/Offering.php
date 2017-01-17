<?php
	class Offering extends AppModel
	{
		public $hasMany = array('OfferInstructor', 'OfferClassroom', 'OfferingParticipant', 'Schedule');
		public $belongsTo = array('Course');
		public $virtualFields = array("encoder_name" => "(SELECT CONCAT(UserProfile.first_name, ' ', UserProfile.last_name) AS AUTHOR FROM user_profiles AS UserProfile WHERE UserProfile.user_id = Offering.user_id LIMIT 1)", "number_of_participants" => "(SELECT COUNT(OfferingParticipant.person_id) FROM offering_participants AS OfferingParticipant WHERE OfferingParticipant.offering_id = Offering.id)");
		
		public function isOwnedBy($offering, $user) 
		{
		    return $this->field('id', array('id' => $offering, 'user_id' => $user)) !== false;
		}
	}
?>