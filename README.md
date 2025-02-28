# groups-non-member-access
Give access to post(s), to non-members of specified group(s).

For example, specify one or more post ids using the filter hook:
add_filter( 'groups_non_member_access_post_ids', 'example_groups_non_member_access_post_ids');
function example_groups_non_member_access_post_ids( $post_ids ) {
	return array( 1234, 2, 3345 );
}
where all users that are not members of the group ids specified by the filter hook:
add_filter( 'groups_non_member_access_group_ids', 'example_groups_non_member_access_group_ids');
function example_groups_non_member_access_group_ids( $group_ids ) {
	return array( 2, 3 );
}
will have access

