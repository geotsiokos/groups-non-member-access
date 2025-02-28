# groups-non-member-access
Give access to post(s), to non-members of specified group(s). When a user is not a member to any of the groups, will have access to the post(s).

For example, we wish to grant access to posts with IDs: 1234, 2, 3345 to all those users that are not members of groups with IDs: 2, 3.

We can specify one or more post ids using the filter hook:

<pre>
<code>
add_filter( 'groups_non_member_access_post_ids', 'example_groups_non_member_access_post_ids');
function example_groups_non_member_access_post_ids( $post_ids ) {
	return array( 1234, 2, 3345 );
}
</code>
</pre>
and one or more group ids using the filter hook:

<pre>
<code>add_filter( 'groups_non_member_access_group_ids', 'example_groups_non_member_access_group_ids');
function example_groups_non_member_access_group_ids( $group_ids ) {
		return array( 2, 3 );
}
</code>
</pre>

