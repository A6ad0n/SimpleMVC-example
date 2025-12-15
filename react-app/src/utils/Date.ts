export const formatDate = (dateString: string): string => {
	const date = new Date(dateString);
	const formatter = new Intl.DateTimeFormat('en-US', {
			month: 'long',
			day: 'numeric'
	});
	return formatter.format(date);
};