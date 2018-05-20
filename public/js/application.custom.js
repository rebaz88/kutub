function formatAttachments(attachments, row) {
  if(Array.isArray(attachments))
    if(attachments.length > 0)
      return attachments.map(function(attachment){return '<a href="' + attachment + '" target="_blank ">Attachment</a>'});

  return (attachments) ? attachments : '---';
}
