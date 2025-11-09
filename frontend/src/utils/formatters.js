export const formatPhoneDisplay = (phone) => {
  if (!phone) return ''
  
  const digitsOnly = phone.replace(/\D/g, '')
  
  if (digitsOnly.length === 10) {
    return `(${digitsOnly.slice(0, 2)}) ${digitsOnly.slice(2, 6)}-${digitsOnly.slice(6)}`
  } else if (digitsOnly.length === 11) {
    return `(${digitsOnly.slice(0, 2)}) ${digitsOnly.slice(2, 7)}-${digitsOnly.slice(7)}`
  }
  
  return phone
}

