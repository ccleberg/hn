<?php

$full_domain = 'https://hn.cleberg.net';
$path = ltrim($_SERVER['REQUEST_URI'], '/');
$elements = explode('/', $path);

if (empty($elements[0])) {
	$html_output = get_stories(
		'https://hacker-news.firebaseio.com/v0/topstories.json?limitToFirst=10&orderBy="$key"',
		'Top'
	);
	echo_html(
		$GLOBALS['full_domain'] . '/top/',
		'The top stories from Hacker News, proxied by hn.',
		'hn',
		$html_output
	);
} else {
	switch (array_shift($elements)) {
		case 'top':
			$html_output = get_stories(
				'https://hacker-news.firebaseio.com/v0/topstories.json?limitToFirst=10&orderBy="$key"',
				'Top'
			);
			echo_html(
				$GLOBALS['full_domain'] . '/top/',
				'The top stories from Hacker News, proxied by hn.',
				'hn',
				$html_output
			);
		break;

		case 'best':
			$html_output = get_stories(
				'https://hacker-news.firebaseio.com/v0/beststories.json?limitToFirst=10&orderBy="$key"',
				'Best'
			);
			echo_html(
				$GLOBALS['full_domain'] . '/best/',
				'The best 30 stories from Hacker News, proxied by hn.',
				'hn ~ best',
				$html_output
			);
		break;

		case 'new':
			$html_output = get_stories(
				'https://hacker-news.firebaseio.com/v0/newstories.json?limitToFirst=10&orderBy="$key"',
				'New'
			);
			echo_html(
				$GLOBALS['full_domain'] . '/new/',
				'The newest 30 stories from Hacker News, proxied by hn.',
				'hn ~ new',
				$html_output
			);
		break;

		case 'ask':
			$html_output = get_stories(
				'https://hacker-news.firebaseio.com/v0/askstories.json?limitToFirst=10&orderBy="$key"',
				'Ask'
			);
			echo_html(
				$GLOBALS['full_domain'] . '/ask/',
				'The latest 30 asks from Hacker News, proxied by hn.',
				'hn ~ ask',
				$html_output
			);
		break;

		case 'show':
			$html_output = get_stories(
				'https://hacker-news.firebaseio.com/v0/showstories.json?limitToFirst=10&orderBy="$key"',
				'Show'
			);
			echo_html(
				$GLOBALS['full_domain'] . '/show/',
				'The latest 30 show stories from Hacker News, proxied by hn.',
				'hn ~ show',
				$html_output
			);
		break;

		case 'job':
			$html_output = get_stories(
				'https://hacker-news.firebaseio.com/v0/jobstories.json?limitToFirst=10&orderBy="$key"',
				'Job'
			);
			echo_html(
				$GLOBALS['full_domain'] . '/job/',
				'The latest 30 job posts from Hacker News, proxied by hn.',
				'hn ~ job',
				$html_output
			);
		break;

		case 'user':
			$html_output = get_user(
				'https://hacker-news.firebaseio.com/v0/user/' . $elements[0]  . '.json',
				'User Profile: ' . $elements[0]
			);
			echo_html(
				$GLOBALS['full_domain'] . '/user/' . $elements[0],
				'The Hacker News profile for ' . $elements[0] . ', proxied by hn.',
				'hn',
				$html_output
			);
		break;

		default:
			header('HTTP/1.1 404 Not Found');
	}
}

/**
* Extract a set of stories from Hacker News API and format in HTML
*
* @access public
* @author cmc <hello@cleberg.net>
* @param string $api_url The API endpoint to use for extraction
* @param string $inline_title The <h1> title to use in the HTML
* @return string $html_output The formatted HTML result of stories from the API
*/
function get_stories($api_url, $inline_title) {
	$response_raw = file_get_contents($api_url);
	if (is_null($response_raw) || $response_raw == "null") {
		$html_output .= '<p>ERROR: Stories not found. API returned `null`.</p>';
		return $html_output;
	} else {
		$response = json_decode($response_raw, true);
	}

	$html_output = '<h1>' . $inline_title . '</h1>';

	for ($i = 0; $i < count($response); $i++) {
		$sub_url = 'https://hacker-news.firebaseio.com/v0/item/' . $response[$i] . '.json';
		$sub_response_raw = file_get_contents($sub_url);
		$sub_response = json_decode($sub_response_raw, true);

		$html = '<div><a href="' . $sub_response['url'] . '">' . $sub_response['title'] . '</a>';
		$html .= '<p><time datetime="' . date('Y-m-d h:m:s', $sub_response['time']) . '">';
		$html .= date('Y-m-d h:m:s', $sub_response['time'])  . '</time> by <a';
		$html .= 'href="/user/'. $sub_response['by'] . '">';
		$html .= $sub_response['by'] . ' | ' . $sub_response['score'];
		$html .= 'points</p></div>';
		$html_output .= $html;
	}

	return $html_output;
}

/**
*Extract a user's profile from Hacker News API and format in HTML
*
* @access public
* @author cmc <hello@cleberg.net>
* @param string $api_url The API endpoint to use for extraction
* @param string $inline_title The <h1> title to use in the HTML
* @return string $html_output The formatted HTML result of stories from the API
*/
function get_user(string $api_url, string $inline_title) {
	$response_raw = file_get_contents($api_url);
	if (is_null($response_raw) || $response_raw == "null") {
		$html_output .= '<p>ERROR: User not found.</p>';
		return $html_output;
	} else {
		$response = json_decode($response_raw, true);
	}

	$html_output = '<h1>' . $inline_title . '</h1>';
	$html_output .= '<p>About: ' . $response['about']  . '</p>';
	$html_output .= '<p>Karma: ' . $response['karma']  . '</p>';
	$html_output .= '<p>Created: <time datetime="' . date('Y-m-d h:m:s', $response['created'])  . '>' . date('Y-m-d h:m:s', $response['created']) . '</time></p>';
	$html_output .= '<p>Recently Submitted Posts:</p>';

	$limit = count($response['submitted']) > 10 ? 10 : count($response['submitted']);
	if (count($response['submitted']) > 0) {
		for ($i = 0; $i < $limit; $i++) {
			$sub_url = 'https://hacker-news.firebaseio.com/v0/item/' . $response['submitted>
			$sub_response_raw = file_get_contents($sub_url);
			$sub_response = json_decode($sub_response_raw, true);

			// TODO: Create switch-case to cover a story, comment, job, poll, or pollopt
			$html = '<div><a href="' . $sub_response['url'] . '">' . $sub_response['title']>
			$html .= '<p><time datetime="' . date('Y-m-d h:m:s', $sub_response['time']) . '>
			$html .= date('Y-m-d h:m:s', $sub_response['time'])  . '</time> by ';
			$html .= $sub_response['by'] . ' | ' . $sub_response['score'] . ' points</p></d>
		$html_output .= $html;
		}
	} else {
		$html_output .= '<p>User has no subsmissions.</p>';
	}

	return $html_output;
}


/**
* Send formatted HTML results to the user via a template
*
* @access public
* @author cmc <hello@cleberg.net>
* @param string $page_url Canoncial URL for HTML header
* @param string $page_description Page description for HTML header
* @param string $page_title Page title for HTML header
* @param string $page_content Page content to display in <main>
*/
function echo_html(string $page_url, string $page_description, string $page_title, string $page_content) {
	include_once 'src/View/class-template.php';

	$template = new HN\View\Template(
		$page_url,
		$page_description,
		$page_title,
		$page_content
	);

	$template->echo_template();
}

// EOF
