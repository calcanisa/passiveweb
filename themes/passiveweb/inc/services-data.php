<?php
defined( 'ABSPATH' ) || exit;

function pw_services() {
	return array(
		array(
			'name'        => 'Design',
			'icon'        => 'pen',
			'summary'     => 'Logos, web, UI and UX design.',
			'description' => 'We shape the visual identity that gets your brand noticed, remembered and trusted.',
			'items'       => array(
				array( 'Graphic Design', 'Any graphic you need, for print or for the web, done properly.' ),
				array( 'Logo Design', 'A distinct mark that carries your brand across every platform.' ),
				array( 'UX Design', 'Intuitive user journeys that make people want to come back.' ),
				array( 'UI Design', 'Clean, on-brand interfaces that are a pleasure to use.' ),
				array( 'Web Design', 'Custom layouts built to turn visitors into paying customers.' ),
				array( 'WordPress Theme Design', 'Bespoke WordPress themes built around your content, not a template.' ),
			),
		),
		array(
			'name'        => 'Development',
			'icon'        => 'code',
			'summary'     => 'Web, mobile, database and AI agents.',
			'description' => 'We write the code that runs your business, built on the language and framework that actually fits the job.',
			'items'       => array(
				array( 'Web Development (Python, PHP, Golang, Rust)', 'Robust backend systems built in whichever language suits the job.' ),
				array( 'Database Development', 'Schemas and queries engineered to stay fast as you scale.' ),
				array( 'AI Agent Development', 'Custom AI agents that automate real work inside your business.' ),
				array( 'Mobile Application Development', 'Native and cross platform apps for iOS and Android.' ),
				array( 'WordPress Plugin Development', 'Custom plugins that extend WordPress exactly the way you need.' ),
			),
		),
		array(
			'name'        => 'Digital Marketing',
			'icon'        => 'megaphone',
			'summary'     => 'SEO, ads, social, email and SMS.',
			'description' => 'We put your business in front of people who are already looking for it, then keep them coming back.',
			'items'       => array(
				array( 'Search Engine Optimization', 'Rank higher on Google and get found by people already searching.' ),
				array( 'Search Engine Marketing (Pay Per Click Management)', 'Paid campaigns managed to get the most from every rand spent.' ),
				array( 'Social Media Marketing', 'Content and campaigns that grow an engaged following.' ),
				array( 'Content Marketing', 'Articles, guides and copy that build trust and authority.' ),
				array( 'Affiliate Marketing', "Partner programs that turn other people's audiences into your customers." ),
				array( 'SMS Marketing', 'Direct, high open rate messages that drive immediate action.' ),
				array( 'Email Marketing', 'Newsletters and automated flows that keep customers coming back.' ),
			),
		),
		array(
			'name'        => 'Web Hosting',
			'icon'        => 'server',
			'summary'     => 'Shared, VPS, dedicated and upkeep.',
			'description' => 'Reliable infrastructure and hands on maintenance so your site stays fast, secure and online.',
			'items'       => array(
				array( 'Shared Web Hosting', "Affordable hosting for smaller sites that don't need dedicated resources." ),
				array( 'VPS Hosting', 'Your own virtual server, with the power to grow with you.' ),
				array( 'Dedicated Server Hosting', 'A physical server reserved entirely for your business.' ),
				array( 'System Administration', 'Ongoing server management so things keep running smoothly.' ),
				array( 'WordPress Website Maintenance', 'Updates, backups and monitoring so your site stays healthy.' ),
			),
		),
		array(
			'name'        => 'Cyber Security',
			'icon'        => 'shield',
			'summary'     => 'Pen testing, audits and POPIA.',
			'description' => 'We find the holes before criminals do, then help you close them for good.',
			'items'       => array(
				array( 'Penetration Testing', 'We attack your systems first, before criminals get the chance.' ),
				array( 'Vulnerability Assessments', 'A full scan of your systems to flag every weak point.' ),
				array( 'Network Security Audits', 'A deep review of your network to close off entry points.' ),
				array( 'Firewall Configuration and Management', 'Rules and monitoring configured to keep intruders out.' ),
				array( 'Malware Removal and Remediation', 'Fast, thorough clean up when something gets in.' ),
				array( 'Security Awareness Training', 'Practical training so your team stops being the weak link.' ),
				array( 'Incident Response and Digital Forensics', 'Rapid response and investigation when a breach happens.' ),
				array( 'Compliance Audits (POPIA, GDPR, PCI DSS)', 'We check your systems against the regulations that matter.' ),
			),
		),
	);
}
