import passport from "passport";
import strategy from "passport-facebook";

const FacebookStrategy = strategy.Strategy;


passport.serializeUser(function(user, done) {
  done(null, user);
});

passport.deserializeUser(function(obj, done) {
  done(null, obj);
});

passport.use(
  new FacebookStrategy(
    {
      clientID: '506733741450314',
      clientSecret: 'ce0c19093fea22b67fc43a3a6f0d5657',
      callbackURL: 'http://localhost:3000/auth/facebook/callback',
      profileFields: ["email", "name"]
    },
    function(request, accessToken, refreshToken, profile, done) {
  return done(null, profile);
}

  )
);