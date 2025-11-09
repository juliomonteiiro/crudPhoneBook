export const validateEmail = (email) => {
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  return emailRegex.test(email)
}

export const validatePhone = (phone) => {
  const phoneRegex = /^[\d\s\(\)\-\+]+$/
  const digitsOnly = phone.replace(/\D/g, '')
  return phoneRegex.test(phone) && digitsOnly.length >= 10 && digitsOnly.length <= 11
}

export const formatPhone = (value) => {
  const digitsOnly = value.replace(/\D/g, '')
  
  if (digitsOnly.length <= 2) {
    return digitsOnly
  } else if (digitsOnly.length <= 6) {
    return `(${digitsOnly.slice(0, 2)}) ${digitsOnly.slice(2)}`
  } else if (digitsOnly.length <= 10) {
    return `(${digitsOnly.slice(0, 2)}) ${digitsOnly.slice(2, 6)}-${digitsOnly.slice(6)}`
  } else {
    return `(${digitsOnly.slice(0, 2)}) ${digitsOnly.slice(2, 7)}-${digitsOnly.slice(7, 11)}`
  }
}

export const formatEmail = (value) => {
  return value.toLowerCase().trim()
}

