// ФИО SHORT NAMES
// Lastname Firstname (without Middle name)
  function fullNameToNoMiddleName(fullName) {
    let names_parts;
    if (fullName) {
      names_parts = fullName.split(' ');
      if (names_parts[2]) {
        return names_parts[0] + ' ' + names_parts[1];
      } else {
        return fullName;
      }
    } else {
      return fullName;
    }
  }
// Lastname F.M. OR Lastname F.
	function fullNameToShortFirstMiddleNames(fullName, nameOnly) {
		var shortName;
		fullName ? fullName = fullName.split(' ') : '';
		if (fullName) {
			shortName = fullName[0] + ' ' + fullName[1][0] + '.';
		}
		if (fullName[2] && !nameOnly && fullName[2] !== '-') {
			shortName = shortName +" "+fullName[2][0] + '. ';
		}
		return shortName;
	}
// STOP SHORT NAMES
