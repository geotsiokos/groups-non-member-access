<?php
/**
 * Plugin Name: Groups non-member access
 * Description: Give access to post(s), to non-members of specified group(s).
 * Author: gtsiokos
 * Author URI: https://www.netpad.gr
 * Plugin URI: https://www.netpad.gr
 * Version: 1.0.0
 */

if( !defined( 'ABSPATH' ) ) {
	exit;
}

class Groups_Non_Member_Access {

	/**
	 * Post ids
	 * @var array
	 */
	private static $post_ids = array();

	/**
	 * Group ids
	 * @var array
	 */
	private static $group_ids = array();

	/**
	 * Init
	 */
	public static function init() {
		add_filter( 'groups_post_access_posts_where', array( __CLASS__, 'groups_post_access_posts_where' ), 10, 2 );
	}

	/**
	 * Adjust posts_where for specified post_ids and group_ids
	 *
	 * @param string $where
	 * @param string $query
	 * @return string
	 */
	public static function groups_post_access_posts_where( $where, $query ) {
		global $wpdb;
		$current_user_id = get_current_user_id();
		if ( $current_user_id ) {
			$post_ids_non_member = self::non_member_access_post_ids();
			$group_ids_non_member = self::non_member_access_group_ids();
			$is_member = self::is_member( $current_user_id, $group_ids_non_member );
			if ( count( $post_ids_non_member ) > 0 ) {
				$post_ids = implode( ' ,', $post_ids_non_member );
				if ( $is_member ) {
					$where .= sprintf(
						" AND {$wpdb->posts}.ID NOT IN ( %s )",
						esc_sql( $post_ids )
					);
				}
			}
		}

		return $where;
	}

	/**
	 * Check if user_id is not member of any of the group_ids
	 *
	 * @param int $user_id
	 * @param array $group_ids
	 * @return boolean
	 */
	public static function is_member( $user_id, $group_ids ) {
		if ( count( $group_ids ) > 0 ) {
			foreach ( $group_ids as $group_id ) {
				if ( Groups_User_Group::read( $user_id, $group_id ) ) {
					$result = true;
					break;
				} else {
					$result = false;
				}
			}
		}
		return $result;
	}

	/**
	 * Filter hook for specifying post_ids
	 * @return array
	 */
	public static function non_member_access_post_ids() {
		return apply_filters( 'groups_non_member_access_post_ids', self::$post_ids );
	}

	/**
	 * Filter hook for specifying group_ids
	 * @return array
	 */
	public static function non_member_access_group_ids() {
		return apply_filters( 'groups_non_member_access_group_ids', self::$group_ids );
	}

} Groups_Non_Member_Access::init();
