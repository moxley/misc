<?php

function test_reset_data()
{
	$data = array(
		'messages' => array(
			array('id'         => '1',
				'subject'      => 'From joe to mary',
				'fromUserID'   => '1',
				'fromUserName' => 'joe',
				'toUserID'     => '2',
				'toUserName'   => 'mary',
				'body'         => 'Hi Mary, from Joe.'
			),
			array('id'         => '2',
				'subject'      => 'From mary to joe',
				'fromUserID'   => '2',
				'fromUserName' => 'mary',
				'toUserID'     => '1',
				'toUserName'   => 'joe',
				'body'         => 'Hi Joe, from Mary.')
		),
		'users' => array(
			array(
				'id'       => '1',
				'userName' => 'joe',
				'title'    => 'Looking for that perfect match',
				'body'     => 'This is Joe\'s profile body'),
			array(
				'id'       => '2',
				'userName' => 'mary',
				'title'    => 'Need a good kick in the pants',
				'body'     => 'This is Mary\'s profile body.'),
			array(
				'id'       => '3',
				'userName' => 'bob',
				'title'    => 'I am a slob',
				'body'     => 'This is Bob\'s profile body.'),
			array(
				'id'       => '4',
				'userName' => 'jane',
				'title'    => 'Looking for a good man',
				'body'     => 'This is Jane\'s profile body.')
		)
	);
    test_save_data($data);
}

function test_get_data()
{
	return unserialize(file_get_contents(LIB_DIR . '/data.ser'));
}

function test_save_data($data)
{
	return file_put_contents(LIB_DIR . '/data.ser', serialize($data));
}
